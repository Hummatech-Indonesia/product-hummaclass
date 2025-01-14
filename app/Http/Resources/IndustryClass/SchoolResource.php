<?php

namespace App\Http\Resources\IndustryClass;

use App\Enums\PaymentMethodSchoolEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SchoolResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($this->payment_method == PaymentMethodSchoolEnum::FROMSCHOOL->value) {
            $payment_method = 'Pembayaran Dari Sekolah';
        } else {
            $payment_method = 'Pembayaran Dari Siswa';
        }
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'name' => $this->name,
            'address' => $this->address,
            'head_master' => $this->head_master,
            'photo' => url('storage/' . $this->photo),
            'description' => $this->description,
            'phone_number' => $this->phone_number,
            'payment_method' => $payment_method,
            'npsn' => $this->npsn,
            'classrooms' => ClassroomResource::collection($this->classrooms)
        ];
    }
}
