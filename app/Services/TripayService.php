<?php

namespace App\Services;

use App\Helpers\ResponseHelper;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class TripayService
{
    public function handlePaymentChannels()
    {
        $res = Http::withToken(config('tripay.api_key'))
            ->get(config('tripay.api_url') . "merchant/payment-channel")
            ->json();

        $channels = collect($res['data'])->groupBy('group');
        $formattedCollection = $channels->mapWithKeys(function ($item, $key) {
            $newKey = strtolower(str_replace(' ', '_', $key));
            $newKey = strtolower(str_replace('-', '_', $newKey));
            return [$newKey => $item];
        });

        return $formattedCollection;
    }
    public function handlePaymentInstructions($code)
    {
        $res = Http::withToken(config('tripay.api_key'))
            ->get(config('tripay.api_url') . "payment/instruction", ['code' => $code])
            ->json();

        return collect($res);
    }

    public static function handleGenerateCallbackSignature(Request $request): string
    {
        $privateKey = config('tripay.private_key');

        return hash_hmac('sha256', $request->getContent(), $privateKey);
    }
    public function handelCreateTransaction(Request $request, Course $course): mixed
    {
        $apiKey       = config('tripay.api_key');
        $privateKey   = config('tripay.private_key');
        $merchantCode = config('tripay.merchant_code');
        $merchantRef  = "HMCLS" . substr(time(), 6);
        $amount       = $course->price;

        $data = [
            'method'         => 'BRIVA',
            'merchant_ref'   => $merchantRef,
            'amount'         => $amount,
            'customer_name'  => auth()->user()->name,
            'customer_email' => auth()->user()->email,
            'customer_phone' => auth()->user()->phone_number,
            'order_items'    => [
                [
                    'sku'         => $course->slug,
                    'name'        => $course->title,
                    'price'       => $course->price,
                    'quantity'    => 1,
                    'product_url' => "env('API_URL)./courses/courses/$course->slug",
                    'image_url'   => $course->photo ?? null,
                ],
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

        return empty($error) ? $response : $error;
    }
}
