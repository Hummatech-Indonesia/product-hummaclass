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
            'total_question' => $this->total_question,
            'duration' => $this->duration,
            'user_quizzes' => $this->userQuizzes,
            'is_submited' => $this->is_submited
        ];
    }
}
