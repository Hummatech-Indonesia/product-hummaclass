<?php

namespace App\Http\Resources;

use App\Enums\GenderEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($this->user->gender == GenderEnum::MALE->value) {
            $gender = 'Laki-laki';
        } else {
            $gender = 'Perempuan';
        }
        return [
            'id' => $this->id,
            'name' => $this->user->name,
            'email' => $this->user->email,
            'gender' => $gender,
            'default_gender' => $this->user->gender,
            'photo' => url('storage/' . $this->user->photo),
            'nisn' => $this->nisn,
            'phone_number' => $this->user->phone_number,
            'date_birth' => $this->date_birth,
            'address' => $this->user->address,
            'school' => $this->school,
        ];
    }
}
