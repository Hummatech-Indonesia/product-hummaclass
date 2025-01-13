<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\IndustryClass\PaymentInterface;
use App\Enums\InvoiceStatusEnum;
use App\Helpers\PaymentHelper;
use Illuminate\Support\Facades\Http;
use App\Helpers\ResponseHelper;
use App\Http\Resources\PaymentResource;
use App\Services\IndustryClass\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    private PaymentService $payment;
    private PaymentInterface $paymentInterface;

    /**
     * __construct
     *
     * @param  mixed $payment
     * @return void
     */
    public function __construct(PaymentService $payment, PaymentInterface $paymentInterface)
    {
        $this->payment = $payment;
        $this->paymentInterface = $paymentInterface;
    }

    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $data = PaymentHelper::paidMonth();
        $getSemester = PaymentHelper::getSemester();
        $monthlyBill = PaymentHelper::monthlyBill();

        $paidMonths = array_column($data, 'month');

        $monthNames = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        $monthStatus = [];

        foreach ($getSemester["month"] as  $month) {
            $status = in_array($month, $paidMonths) ? 'paid' : 'unpaid';
            $monthStatus[$month] = [
                'month_numeric' => $month,
                'month' => $monthNames[$month],
                'status' => $status,
                'semester' => $getSemester["semester"],
                'monthlyBill' => $monthlyBill
            ];
        }

        return ResponseHelper::success($monthStatus);
    }

    /**
     * store
     *
     * @return void
     */
    public function store(Request $request)
    {
        $paymentUser = auth()->user()->payments->where('invoice_status', InvoiceStatusEnum::PENDING->value)->where('expiry_date', '>=', now())->first();

        if ($paymentUser == null) {
            $payment = $this->payment->store($request);
            if ($payment->success) {
                return ResponseHelper::success($payment, 'Berhasil melakukan request pembayaran');
            } else {
                return ResponseHelper::error(null, $payment->message);
            }
        } else {
            return ResponseHelper::error(null, "Selesaikan Transaksi Sebelumnya");
        }
    }

    /**
     * checkStatus
     *
     * @param  mixed $reference
     * @return void
     */
    public function checkStatus($reference)
    {
        $response = Http::withToken(config('tripay.api_key'))->get(config('tripay.api_url') . 'transaction/detail?reference=' . $reference);

        return $response;
    }

    /**
     * show
     *
     * @param  mixed $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $payment = $this->paymentInterface->show($id);
        return ResponseHelper::success(PaymentResource::make($payment));
    }
}
