<?php

namespace App\Services\IndustryClass;

use App\Contracts\Interfaces\IndustryClass\PaymentInterface;
use App\Enums\InvoiceStatusEnum;
use App\Helpers\PaymentHelper;
use Illuminate\Http\Request;

class PaymentService
{

    private PaymentInterface $payment;

    public function __construct(PaymentInterface $payment)
    {
        $this->payment = $payment;
    }

    public function store(Request $request)
    {
        $month = $request->month;
        $monthlyBill = PaymentHelper::monthlyBill();

        $apiKey       = config('tripay.api_key');
        $privateKey   = config('tripay.private_key');
        $merchantCode = config('tripay.merchant_code');
        $merchantRef  = "HMCLS" . substr(time(), 6);
        $amount       = $monthlyBill * count($month);

        // Buat array order_items
        $orderItems = [];

        $months = [
            1 => ['name' => 'Januari', 'sku' => 'month-01'],
            2 => ['name' => 'Februari', 'sku' => 'month-02'],
            3 => ['name' => 'Maret', 'sku' => 'month-03'],
            4 => ['name' => 'April', 'sku' => 'month-04'],
            5 => ['name' => 'Mei', 'sku' => 'month-05'],
            6 => ['name' => 'Juni', 'sku' => 'month-06'],
            7 => ['name' => 'Juli', 'sku' => 'month-07'],
            8 => ['name' => 'Agustus', 'sku' => 'month-08'],
            9 => ['name' => 'September', 'sku' => 'month-09'],
            10 => ['name' => 'Oktober', 'sku' => 'month-10'],
            11 => ['name' => 'November', 'sku' => 'month-11'],
            12 => ['name' => 'Desember', 'sku' => 'month-12'],
        ];

        foreach ($request->month as $m) {
            $orderItems[] = [
                'sku'      => $months[$m]['sku'],
                'name'     => $months[$m]['name'],
                'price'    => $monthlyBill,
                'quantity' => 1,
            ];
        }

        foreach ($month as $m) {
            $detailPayment[] = [
                'month' => $m,
                'price' => $monthlyBill,
                'year' => intval(now()->format('Y'))
            ];
        }


        $data = [
            'method'         => $request->payment_method,
            'merchant_ref'   => $merchantRef,
            'amount'         => $amount,
            'customer_name'  => auth()->user()->name,
            'customer_email' => auth()->user()->email,
            'customer_phone' => auth()->user()->phone_number,
            'order_items'    => $orderItems,
            'return_url'     => 'https://domainanda.com/redirect',
            'expired_time'   => (time() + (24 * 60 * 60)), // 24 jam
            'signature'      => hash_hmac('sha256', $merchantCode . $merchantRef . $amount, $privateKey)
        ];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_FRESH_CONNECT  => true,
            CURLOPT_URL            => config('tripay.api_url') . 'transaction/create',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_HTTPHEADER     => ['Authorization: Bearer ' . $apiKey],
            CURLOPT_FAILONERROR    => false,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => http_build_query($data),
            CURLOPT_IPRESOLVE      => CURL_IPRESOLVE_V4
        ]);

        $response = curl_exec($curl);
        $responseDecode = json_decode($response);
        if ($response && $responseDecode->success) {
            $payment = $this->payment->store([
                'user_id' => auth()->user()->id,
                'fee_amount' => $responseDecode->data->total_fee,
                'invoice_id' => $responseDecode->data->merchant_ref,
                'amount' => $responseDecode->data->amount_received,
                'expiry_date' => gmdate('Y-m-d H:i:s', $responseDecode->data->expired_time),
                'paid_amount' => $responseDecode->data->amount,
                'payment_channel' => $responseDecode->data->payment_name,
                'payment_method' => $responseDecode->data->payment_method,
                'invoice_status' => InvoiceStatusEnum::PENDING->value,
            ]);
            foreach ($detailPayment as $detail) {
                $payment->detailPayments()->create($detail);
            }
        }
        $error = curl_error($curl);

        curl_close($curl);

        return empty($error) ? $responseDecode : $error;
    }
}
