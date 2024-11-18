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
            'student' => $this->user->name,
            'email' => $this->user->email,
            'gender' => $gender,
            'photo' => url('storage/' . $this->user->photo),
            'nisn' => $this->nisn,
            'school' => $this->school->name,
        ];
    }
}
