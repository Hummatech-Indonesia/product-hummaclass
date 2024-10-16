<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserQuizResultResource extends JsonResource
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
            'created' => $this->created_at->format('j F Y H:i'),
            'score' => $this->score,
            'status' => $this->score > $this->quiz->minimum_score ? 'Lulus' : 'Tidak Lulus',
        ];
    }
}
