<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TestHistoryResource extends JsonResource
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
            'user_name' => $this->user->name,
            'user' => $this->user,
            'course_test' => $this->courseTest,
            'module_question_ids' => $this->module_question_id,
            'answer' => $this->answer,
            'score' => number_format($this->score, 1),
            'test_type' => $this->test_type,
            'created_at' => $this->created_at->format('j F Y H:i'),
        ];
    }
}
