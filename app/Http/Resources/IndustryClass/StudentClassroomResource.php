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
            'student_id' => $this->student->id,
            'class' => $this->classroom->name,
            'photo' => url('storage/' . $this->student->user->photo),
            'email' => $this->student->user->email,
            'address' => $this->student->user->address,
            'phone_number' => $this->student->user->phone_number,
            'gender' => $gender,
            'nisn' => $this->student->nisn,
            'date_birth' => $this->student->date_birth,
        ];
    }
}
