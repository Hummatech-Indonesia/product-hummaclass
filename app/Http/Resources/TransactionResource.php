<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user,
            'course_id' => $this->course,
            'event_id' => $this->event,
            'invoice_id' => $this->invoice_id,
            'fee_amount' => $this->fee_amount,
            'amount' => $this->amount,
            'invoice_url' => $this->invoice_url,
            'expiry_date' => $this->expiry_date,
            'paid_amount' => $this->paid_amount,
            'payment_channel' => $this->payment_channel,
            'payment_method' => $this->payment_method,
            'invoice_status' => $this->invoice_status,
            'voucher' => $this->voucher,
        ];
    }

}
