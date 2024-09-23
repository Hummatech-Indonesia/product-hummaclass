<?php

namespace App\Http\Controllers\Payment;

use Carbon\Carbon;
use App\Models\Course;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Services\TripayService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\PaymentChannelResource;
use App\Contracts\Interfaces\TransactionInterface;

class TransactionController extends Controller
{
    private TransactionInterface $transaction;
    private TripayService $service;
    public function __construct(TransactionInterface $transaction, TripayService $service)
    {
        $this->transaction = $transaction;
        $this->service = $service;
    }
    public function getPaymentChannels(): JsonResponse
    {
        $paymentChannels = $this->service->handlePaymentChannels();
        return ResponseHelper::success($paymentChannels, trans('alert.fetch_success'));
    }
    public function getPaymentInstructions(Request $request): JsonResponse
    {
        return response()->json($paymentInstructions = $this->service->handlePaymentInstructions($request->code));
        // return ResponseHelper::success($paymentInstructions, trans('alert.fetch_success'));
    }

    public function show(mixed $id): mixed
    {
        $transaction = $this->transaction->show($id);
        return ResponseHelper::success($transaction);
    }
    public function store(Request $request, Course $course): mixed
    {
        $transaction = json_decode($this->service->handelCreateTransaction($course), 1);

        // return $transaction;
        if ($transaction['success']) {
            $data = [
                'id' => $transaction['data']['reference'],
                'user_id' => auth()->user()->id,
                'course_id' => $course->id,
                'invoice_id' => $transaction['data']['merchant_ref'],
                'fee_amount' => $transaction['data']['fee_merchant'],
                'amount' => 1,
                'invoice_url' => $transaction['data']['checkout_url'],
                'expiry_date' => Carbon::createFromTimestamp($transaction['data']['expired_time'])->toDateTimeString(),
                'paid_amount' => 1,
                // 'paid_at' => '',
                'payment_channel' => $transaction['data']['payment_name'],
                'payment_method' => $transaction['data']['payment_method']
            ];
            $created = $this->transaction->store($data);
            return ResponseHelper::success(null, 'Transaksi berhasil');
        } else {
            ResponseHelper::error('Transaksi Gagal');
        }
    }

    public function callback(Request $request)
    {
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
    }
    public function returnCallback(Request $request)
    {
        return 'return callback';
    }

    public function checkStatus(Request $request)
    {
        // return $request->referense;
        // return config('tripay.api_url');
        $response = Http::withToken(config('tripay.api_key'))->get(config('tripay.api_url') . 'transaction/check-status', [
            'reference' => $request->referense
        ]);

        return $response;
    }

    public function update(mixed $id, array $data): mixed
    {
        return '';
    }

    public function delete(mixed $id): mixed
    {
        return $this->delete($id);
    }
}
