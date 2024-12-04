<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceStudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->student->user->name,
            'classroom' => $this->student->studentClassrooms()->latest()->first()->classroom->name,
            'school' => $this->student->school->name,
        ];
    }
}
