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
            'slug' => $this->slug,
            'division' => $this->division,
            'class_level' => $this->class_level,
            'school' => $this->school,
            'mentor' => $this->user,
            'price' => $this->price,
            'student_classrooms' => StudentClassroomResource::collection($this->studentClassrooms),
            'teacher' => TeacherResource::make($this->teacher),
            'school_year' => $this->schoolYear,
        ];
    }
}
