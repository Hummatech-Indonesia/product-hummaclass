<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseTestResource extends JsonResource
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
            'duration' => $this->duration,
            'total_question' => $this->total_question,
            'is_submitted' => $this->is_submitted,
            'courseTestQuestions' => CourseTestQuestionResource::collection($this->courseTestQuestions)
        ];
    }
}
