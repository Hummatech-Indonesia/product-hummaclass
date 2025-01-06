<?php

namespace App\Services;

use App\Helpers\ResponseHelper;
use App\Models\Course;
use App\Models\CourseVoucher;
use App\Models\Event;
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

    /**
     * handleGenerateCallbackSignature
     *
     * @param  mixed $request
     * @return string
     */
    public static function handleGenerateCallbackSignature(Request $request): string
    {
        $privateKey = config('tripay.private_key');

        return hash_hmac('sha256', $request->getContent(), $privateKey);
    }

    /**
     * handelCreateTransaction
     *
     * @param  mixed $request
     * @param  mixed $course
     * @param  mixed $courseVoucher
     * @return mixed
     */
    public function handelCreateTransaction(Request $request, Course | Event $product, CourseVoucher | null $courseVoucher): mixed
    {
        $apiKey       = config('tripay.api_key');
        $privateKey   = config('tripay.private_key');
        $merchantCode = config('tripay.merchant_code');
        $merchantRef  = "HMCLS" . substr(time(), 6);
        $productPrice = $product->promotional_price == null || $product->promotional_price == 0 ? $product->price : $product->promotional_price;
        $amount       = $courseVoucher ? $productPrice - ($productPrice * ($courseVoucher->discount / 100)) : $productPrice;
        // $amount       = $product->price;
        $data = [
            'method'         => $request->payment_method,
            'merchant_ref'   => $merchantRef,
            'amount'         => $amount,
            'customer_name'  => auth()->user()->name,
            'customer_email' => auth()->user()->email,
            'customer_phone' => auth()->user()->phone_number,
            'order_items'    => [
                [
                    'sku'         => $product->slug,
                    'name'        => $product->title,
                    'price'       => $amount,
                    'quantity'    => 1,
                    'product_url' => env('API_URL') . "/courses/courses/$product->slug",
                    'image_url'   => $product->photo ?? null,
                ],
            ],
            'return_url'   => env('API_URL') . '/api/callback',
            'expired_time' => (time() + (24 * 60 * 60)), // 24 jam
            'signature'    => hash_hmac('sha256', $merchantCode . $merchantRef . $amount, $privateKey)
        ];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_FRESH_CONNECT  => true,
            CURLOPT_URL            => (config('tripay.api_url')) . 'transaction/create',
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
