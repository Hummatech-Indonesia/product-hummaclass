<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizResource extends JsonResource
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
            'module_id' => $this->module_id,
            'course_slug' => $this->module->course->slug,
            'course_title' => $this->module->course->title,
            'module_title' => $this->module->title,
            'rules' => $this->rules,
            'module_slug' => $this->module->slug,
            'total_question' => $this->total_question,
            'minimum_score' => $this->minimum_score,
            'duration' => $this->duration,
            'retry_delay' => $this->retry_delay,
            'user_quizzes' => $this->userQuizzes->sortByDesc('created_at')->first(),
            'is_submited' => $this->is_submited,
            'created_at' => $this->created_at
        ];
    }
}
