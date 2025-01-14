<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MentorResource extends JsonResource
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
            'photo' => $this->user->photo !== null ? url('storage/' . $this->user->photo) : null,
            'name' => $this->user->name,
            'email' => $this->user->email,
            'phone_number' => $this->user->phone_number,
            'address' => $this->user->address,
            'gender' => $this->user->gender,
            'rekening_number' => $this->rekening_number,
            'bank_name' => $this->bank_name,
            'created' => Carbon::parse($this->created_at)->format('d F Y'),
        ];
    }
}
