<?php

namespace App\Http\Resources\IndustryClass;

use App\Http\Resources\TeacherResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClassroomResource extends JsonResource
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
            'name' => $this->name,
            'division' => $this->division,
            'class_level' => $this->class_level,
            'school' => $this->school,
            'mentor' => $this->user,
            'teacher' => TeacherResource::make($this->teacher),
            'school_year' => $this->schoolYear,
        ];
    }
}