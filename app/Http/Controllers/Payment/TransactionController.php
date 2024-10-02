<?php

namespace App\Http\Controllers\Payment;

use App\Contracts\Interfaces\Course\CourseVoucherInterface;
use Carbon\Carbon;
use App\Models\Course;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Services\TripayService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\TransactionService;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\PaymentChannelResource;
use App\Contracts\Interfaces\TransactionInterface;
use App\Http\Resources\TransactionResource;
use App\Models\User;

class TransactionController extends Controller
{
    private TransactionInterface $transaction;
    private CourseVoucherInterface $courseVoucher;
    private TripayService $service;
    private TransactionService $transactionService;
    public function __construct(TransactionInterface $transaction, CourseVoucherInterface $courseVoucher, TransactionService $transactionService, TripayService $service)
    {
        $this->transaction = $transaction;
        $this->courseVoucher = $courseVoucher;
        $this->transactionService = $transactionService;
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
    public function index(): JsonResponse
    {
        $transactions = $this->transaction->get();
        return ResponseHelper::success(TransactionResource::collection($transactions), trans('alert.fetch_success'));
    }
    public function getByUser(): JsonResponse
    {
        $transactions = $this->transaction->getWhere(['user_id' => auth()->user()->id]);
        return ResponseHelper::success(TransactionResource::collection($transactions), trans('alert.fetch_success'));
    }

    public function show(mixed $id): mixed
    {
        $transaction = $this->transaction->show($id);
        return ResponseHelper::success($transaction);
    }

    /**
     * store
     *
     * @param  mixed $request
     * @param  mixed $course
     * @return mixed
     */
    public function store(Request $request, Course $course): mixed
    {
        $voucher = $this->courseVoucher->getByCode($request->voucher_code);
        $transaction = json_decode($this->service->handelCreateTransaction($request, $course, $voucher), 1);
        if ($transaction['success']) {
            $data = [
                'id' => $transaction['data']['reference'],
                'user_id' => auth()->user()->id,
                'course_id' => $course->id,
                'invoice_id' => $transaction['data']['merchant_ref'],
                'fee_amount' => $transaction['data']['fee_merchant'],
                'amount' => $course->price,
                'invoice_url' => $transaction['data']['checkout_url'],
                'expiry_date' => Carbon::createFromTimestamp($transaction['data']['expired_time'])->toDateTimeString(),
                'paid_amount' => 0,
                'payment_channel' => $transaction['data']['payment_name'],
                'payment_method' => $transaction['data']['payment_method'],
                'course_voucher_id' => $voucher->id ?? null
            ];
            $this->transaction->store($data);
            return ResponseHelper::success(['transaction' => $transaction, 'voucher' => $voucher], 'Transaksi berhasil');
        } else {
            return ResponseHelper::error($transaction);
        }
    }

    /**
     * callback
     *
     * @param  mixed $request
     * @return void
     */
    public function callback(Request $request)
    {
        return $this->transactionService->handlePaymentCallback($request);
    }

    /**
     * returnCallback
     *
     * @param  mixed $request
     * @return void
     */
    public function returnCallback(Request $request)
    {
        return 'return callback';
    }

    public function checkStatus(Request $request, $reference)
    {
        $response = Http::withToken(config('tripay.api_key'))->get(config('tripay.api_url') . 'transaction/detail?reference=' . $reference);

        // dd($response->getStatusCode());
        return $response;
    }

    public function delete(mixed $id): mixed
    {
        return $this->delete($id);
    }
}
