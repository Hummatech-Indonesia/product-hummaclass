<?php

namespace App\Services;

use App\Helpers\ResponseHelper;
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

        return collect($res['data'])->groupBy('group');
    }
    public function handlePaymentInstructions($code)
    {
        $res = Http::withToken(config('tripay.api_key'))
            ->get(config('tripay.api_url') . "payment/instruction", ['code' => $code])
            ->json();

        return collect($res);
    }

    public function handleGenerateSignature(Request $request): string
    {
        $privateKey = config('tripay.private_key');

        // ambil data json callback notifikasi
        $json = file_get_contents('php://input');
        $signature = hash_hmac('sha256', $json, $privateKey);
        // $signature = hash_hmac('sha256', $merchantCode . $merchantRef . $amount, $privateKey);

        // result
        // 9f167eba844d1fcb369404e2bda53702e2f78f7aa12e91da6715414e65b8c86a
        return $signature;
    }
}
