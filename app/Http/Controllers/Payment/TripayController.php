<?php

namespace App\Http\Controllers\Payment;

use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Services\TripayService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\PaymentChannelResource;

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
    public function getPaymentInstructions(Request $request): JsonResponse
    {
        return response()->json($paymentInstructions = $this->service->handlePaymentInstructions($request->code));
        // return ResponseHelper::success($paymentInstructions, trans('alert.fetch_success'));
    }

    public function generateSignature(Request $request): string
    {
        return $this->service->handleGenerateSignature($request);
    }
    public function createTransaction()
    {
        // return Http::withToken(config('tripay.api_key'))
        //     ->post(config('tripay.api_url') . "transaction/create", $data)
        //     ->json();

        $apiKey       = config('tripay.api_key');
        $privateKey   = config('tripay.private_key');
        $merchantCode = config('tripay.merchant_code');
        $merchantRef  = 'abc';
        $amount       = 1000000;

        $data = [
            'method'         => 'BRIVA',
            'merchant_ref'   => $merchantRef,
            'amount'         => $amount,
            'customer_name'  => 'Nama Pelanggan',
            'customer_email' => 'emailpelanggan@domain.com',
            'customer_phone' => '081234567890',
            'order_items'    => [
                [
                    'sku'         => 'FB-06',
                    'name'        => 'Nama Produk 1',
                    'price'       => 500000,
                    'quantity'    => 1,
                    'product_url' => 'https://tokokamu.com/product/nama-produk-1',
                    'image_url'   => 'https://tokokamu.com/product/nama-produk-1.jpg',
                ],
                [
                    'sku'         => 'FB-07',
                    'name'        => 'Nama Produk 2',
                    'price'       => 500000,
                    'quantity'    => 1,
                    'product_url' => 'https://tokokamu.com/product/nama-produk-2',
                    'image_url'   => 'https://tokokamu.com/product/nama-produk-2.jpg',
                ]
            ],
            'return_url'   => 'http://127.0.0.1:8000/api/callback',
            'expired_time' => (time() + (24 * 60 * 60)), // 24 jam
            'signature'    => hash_hmac('sha256', $merchantCode . $merchantRef . $amount, $privateKey)
        ];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_FRESH_CONNECT  => true,
            CURLOPT_URL            => 'https://tripay.co.id/api-sandbox/transaction/create',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_HTTPHEADER     => ['Authorization: Bearer ' . $apiKey],
            CURLOPT_FAILONERROR    => false,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => http_build_query($data),
            CURLOPT_IPRESOLVE      => CURL_IPRESOLVE_V4
        ]);

        $response = curl_exec($curl);
        $error = curl_error($curl);

        curl_close($curl);

        echo empty($error) ? $response : $error;
    }

    public function callback(Request $request)
    {
        dd($request);
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
}
