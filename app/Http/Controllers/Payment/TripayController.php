<?php

namespace App\Http\Controllers\Payment;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentChannelResource;
use App\Services\TripayService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TripayController extends Controller
{
    private TripayService $service;
    public function __construct(TripayService $service)
    {
        $this->service = $service;
    }
    public function getPaymentChannels(): JsonResponse
    {
        $paymentChannels = $this->service->handlePaymentChannels();
        return ResponseHelper::success($paymentChannels, trans('alert.fetch_success'));
    }
    public function getPaymentInstructions(): JsonResponse
    {
        $paymentInstructions = $this->service->handlePaymentInstructions();
        return ResponseHelper::success($paymentInstructions, trans('alert.fetch_success'));
    }
}
