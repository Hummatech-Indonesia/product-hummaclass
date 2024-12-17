<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssesmentFormStudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'student' => ['name' => $this->user->name, 'photo' => url('storage/' . $this->user->photo)],
            'classroom' => $this->studentClassrooms()->latest()->first()->classroom->name,
            'value' => $this->assesmentFormStudents->sum('value') != 0 ? 100 / $this->assesmentFormStudents->sum('value') * $this->assesmentFormStudents->count() : 0,
        ];
    }
}
