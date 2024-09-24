<?php

namespace App\Services;

use App\Helpers\ResponseHelper;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class TransactionService
{
    public function handlePaymentChannels()
    {
        $res = Http::withToken(config('tripay.api_key'))
            ->get(config('tripay.api_url') . "merchant/payment-channel")
            ->json();

        return collect($res['data'])->groupBy('group');
    }

    public function handlePaymentCallback($request): mixed {
        switch ($request->status) {
            case 'paid':
                return $request->status;
                break;
            
            default:
                # code...
                break;
        }
    }
}
