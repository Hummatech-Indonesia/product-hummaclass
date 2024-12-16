<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LearningPathResource extends JsonResource
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
            'course_learning_paths' => CourseLearningPathResource::collection($this->courseLearningPaths()->orderBy('step', 'asc')->get()),
            'division' => $this->division,
            'class_level' => $this->class_level
        ];
    }
}
