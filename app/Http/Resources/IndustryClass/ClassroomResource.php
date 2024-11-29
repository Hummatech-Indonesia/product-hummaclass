<?php

namespace App\Http\Resources\IndustryClass;

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
            'school_year' => $this->schoolYear,
            'teacher' => $this->teacher,
            'mentor' => $this->user,
        ];
    }
}
