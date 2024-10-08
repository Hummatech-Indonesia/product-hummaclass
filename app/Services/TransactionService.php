<?php

namespace App\Services;

use App\Contracts\Interfaces\Course\UserCourseInterface;
use App\Contracts\Interfaces\Course\UserEventInterface;
use App\Contracts\Interfaces\TransactionInterface;
use App\Helpers\ResponseHelper;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class TransactionService
{
    private TransactionInterface $transaction;
    private UserCourseInterface $userCourse;
    private UserEventInterface $userEvent;
    public function __construct(TransactionInterface $transaction, UserCourseInterface $userCourse, UserEventInterface $userEvent)
    {
        $this->transaction = $transaction;
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

    /**
     * handlePaymentCallback
     *
     * @param  mixed $request
     * @return mixed
     */
    public function handlePaymentCallback($request): mixed
    {
        $transaction = $this->transaction->show($request->reference);
        $product = $transaction->course ?? $transaction->event;

        if (is_object($product) && get_class($product) == Course::class) {
            $this->userCourse->store([
                'user_id' => $transaction->user_id,
                'course_id' => $transaction->course_id,
                'sub_module_id' => $product->modules->first()->subModules->first()->id
            ]);
        } else {
            $this->userEvent->store([
                'user_id' => $transaction->user_id,
                'event_id' => $transaction->event_id
            ]);
        }
        $data = null;
        switch ($request->status) {
            case 'UNPAID':
                $data = [
                    'invoice_status' => 'unpaid'
                ];
                break;
            case 'PAID':
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
