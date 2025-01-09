<?php

namespace App\Http\Controllers;

use App\Helpers\PaymentHelper;
use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct() {}

    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $data =  PaymentHelper::paidMonth();
        $getSemester = PaymentHelper::getSemester();

        $paidMonths = array_column($data, 'month');

        $monthStatus = [];

        foreach ($getSemester["month"] as $month) {
                $monthStatus[$month] = in_array($month, $paidMonths) ? 'paid' : 'unpaid';
        }

        return ResponseHelper::success($monthStatus);
    }
}
