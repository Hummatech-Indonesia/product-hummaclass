<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChallengeSubmitResource extends JsonResource
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
            'student_name' => $this->student->user->name,
            'student_id' => $this->student->id,
            'student_class' => $this->student->studentClassrooms()->latest()->first()->classroom->name,
            'status' => $this->status,
            'point' => $this->point
        ];
    }
}
