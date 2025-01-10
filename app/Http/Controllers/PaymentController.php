<?php

namespace App\Http\Controllers;

use App\Helpers\PaymentHelper;
use App\Helpers\ResponseHelper;
use App\Services\IndustryClass\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    private PaymentService $payment;

    /**
     * __construct
     *
     * @param  mixed $payment
     * @return void
     */
    public function __construct(PaymentService $payment)
    {
        $this->payment = $payment;
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

        foreach ($getSemester["month"] as $month) {
            $status = in_array($month, $paidMonths) ? 'paid' : 'unpaid';
            $monthStatus[$month] = [
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
        $payment = $this->payment->store($request);
        if ($payment) {
            return ResponseHelper::success($payment, 'Berhasil melakukan request pembayaran');
        } else {
            return ResponseHelper::error($payment);
        }
    }
}
