<?php

namespace App\Services;

use App\Contracts\Interfaces\Course\UserCourseInterface;
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
    public function __construct(TransactionInterface $transaction, UserCourseInterface $userCourse)
    {
        $this->transaction = $transaction;
        $this->userCourse = $userCourse;
    }
    public function handlePaymentChannels()
    {
        $res = Http::withToken(config('tripay.api_key'))
            ->get(config('tripay.api_url') . "merchant/payment-channel")
            ->json();

        return collect($res['data'])->groupBy('group');
    }

    public function handlePaymentCallback($request): mixed
    {
        $transaction = $this->transaction->show($request->reference);
        switch ($request->status) {
            case 'UNPAID':
                $userCourse = $this->userCourse->store([
                    'user_id' => $transaction->user_id,
                    'course_id' => $transaction->course_id
                ]);

                if ($userCourse) {
                    $data = [
                        'invoice_status' => 'unpaid'
                    ];
                    return $this->transaction->update($request->reference, $data);
                }
                return 'callback failed';
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
                return $this->transaction->update($request->reference, $data);
                break;
            case 'EXPIRED':
                $userCourse = $this->userCourse->showByUserCourse($transaction->user_id, $transaction->course_id)->delete();
                $data = [
                    'invoice_status' => 'expired'
                ];
                return $this->transaction->update($request->reference, $data);
                break;
            case 'FAILED':
                $userCourse = $this->userCourse->showByUserCourse($transaction->user_id, $transaction->course)->delete();
                $data = [
                    'invoice_status' => 'failed'
                ];
                return $this->transaction->update($request->reference, $data);
                break;

            default:
                return $request;
                break;
        }
    }
}
