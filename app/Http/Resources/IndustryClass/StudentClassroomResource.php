<?php

namespace App\Http\Resources\IndustryClass;

use App\Enums\GenderEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentClassroomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($this->student->user->gender == GenderEnum::MALE->value) {
            $gender = 'Laki-laki';
        } else {
            $gender = 'Perempuan';
        }
        return [
            'id' => $this->id,
            'student' => $this->student->user->name,
            'photo' => url('storage/' . $this->student->user->photo),
            'email' => $this->student->user->email,
            'gender' => $gender,
            'nisn' => $this->student->nisn
        ];
    }
}
