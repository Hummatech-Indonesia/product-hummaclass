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
            'user' => $this->user,  // ID user
            'product' => $this->event ?? CourseResource::make($this->course),  // ID course
            'invoice_id' => $this->invoice_id,  // ID invoice
            'fee_amount' => $this->fee_amount,  // Biaya yang ditentukan
            'amount' => $this->amount,  // Jumlah pembayaran
            'invoice_url' => $this->invoice_url,  // URL untuk invoice
            'expiry_date' => $this->expiry_date,  // Tanggal kadaluwarsa
            'paid_amount' => $this->paid_amount,  // Jumlah yang sudah dibayar
            'payment_channel' => $this->payment_channel,  // Channel pembayaran
            'payment_method' => $this->payment_method,  // Metode pembayaran
            'invoice_status' => $this->invoice_status,  // Status invoice
            'course_voucher' => $this->courseVoucher,  // Relasi ke voucher course (jika ada)
            'created_at' => $this->created_at->format('j F Y')
        ];
    }
}
