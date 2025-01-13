<?php

namespace App\Services;

use App\Contracts\Interfaces\Course\UserCourseInterface;
use App\Contracts\Interfaces\Course\UserEventInterface;
use App\Contracts\Interfaces\IndustryClass\PaymentInterface;
use App\Contracts\Interfaces\TransactionInterface;
use App\Helpers\ResponseHelper;
use App\Jobs\SendEmailEventJob;
use App\Jobs\SendEventEmailJob;
use App\Mail\EventEmail;
use App\Models\Course;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class TransactionService
{
    private TransactionInterface $transaction;
    private UserCourseInterface $userCourse;
    private PaymentInterface $payment;
    private UserEventInterface $userEvent;
    public function __construct(TransactionInterface $transaction, UserCourseInterface $userCourse, UserEventInterface $userEvent, PaymentInterface $payment)
    {
        $this->transaction = $transaction;
        $this->payment = $payment;
        $this->userCourse = $userCourse;
        $this->userEvent = $userEvent;
    }
    public function handlePaymentChannels()
    {
        $res = Http::withToken(config('tripay.api_key'))
            ->get(config('tripay.api_url') . "merchant/payment-channel")
            ->json();

        return collect($res['data'])->groupBy('group');
    }


    public function handleCerateUserCourse($product, $transaction): mixed
    {
        if (is_object($product) && get_class($product) == Course::class) {
            return $this->userCourse->store([
                'user_id' => $transaction->user_id,
                'course_id' => $transaction->course_id,
                'sub_module_id' => Module::where('course_id', $product->id)->whereHas('subModules')->orderBy('step', 'asc')->first()->subModules->first()->id
            ]);
        } else {
            return $this->userEvent->store([
                'user_id' => $transaction->user_id,
                'event_id' => $transaction->event_id
            ]);
        }
    }

    /**
     * handlePaymentCallback
     *
     * @param  mixed $request
     * @return mixed
     */
    public function handlePaymentCallback($request): mixed
    {
        $payment = $this->payment->show($request->reference);
        if ($payment) {
            switch ($request->status) {
                case 'UNPAID':
                    $data = [
                        'invoice_status' => 'unpaid'
                    ];
                    break;
                case 'PAID':

                    break;
                case 'EXPIRED':
                    $data = [
                        'invoice_status' => 'expired'
                    ];
                    $payment->delete();
                    break;
                case 'FAILED':
                    $data = [
                        'invoice_status' => 'failed'
                    ];
                    $payment->delete();
                    break;
                default:
                    return $request;
                    break;
            }
            $payment->update($data);
            return ResponseHelper::success(null, "Callback success");
        } else {
            $transaction = $this->transaction->show($request->reference);
            $product = $transaction->course ?? $transaction->event;
            $product->type = $transaction->course ? 'course' : 'event';
            $created = $this->handleCerateUserCourse($product, $transaction);
            $data = null;

            // return response()->json($created->user);
            switch ($request->status) {
                case 'UNPAID':
                    $data = [
                        'invoice_status' => 'unpaid'
                    ];
                    break;
                case 'PAID':
                    if ($product->type == 'event') {
                        $this->sendEmailEvent([
                            'email' => $created->user->email,
                            'content' => $product->email_content
                        ]);
                    }
                    $data = [
                        'id' => $request->reference,
                        'invoice_id' => $request->merchant_ref,
                        'fee_amount' => $request->fee_merchant,
                        'paid_amount' => $request->total_amount,
                        'payment_channel' => $request->payment_method,
                        'payment_method' => $request->payment_method_code,
                        'invoice_status' => $request->status
                    ];
                    break;
                case 'EXPIRED':
                    $data = [
                        'invoice_status' => 'expired'
                    ];
                    $product->delete();
                    break;
                case 'FAILED':
                    $data = [
                        'invoice_status' => 'failed'
                    ];
                    $product->delete();
                    break;
                default:
                    return $request;
                    break;
            }
            $updated =  $this->transaction->update($request->reference, $data);
            if ($updated) {
                return ResponseHelper::success(null, "Callback success");
            } else {
                return ResponseHelper::error(null, "Callback gagal");
            }
        }
    }

    public function sendEmailEvent($data): mixed
    {
        return SendEmailEventJob::dispatch($data);
    }
}
