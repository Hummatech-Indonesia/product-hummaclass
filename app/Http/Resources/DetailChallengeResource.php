<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailChallengeResource extends JsonResource
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
            'school' => $this->classroom->school->name,
            'school_slug' => $this->classroom->school->slug,
            'classroom' => $this->classroom->name,
            'classroom_id' => $this->classroom->id,
            'description' => $this->description,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'challenge_submits' => ChallengeSubmitResource::collection($this->challengeSubmits),
            'title' => $this->title,
            'image_active' => $this->image_active,
            'link_active' => $this->link_active,
            'file_active' => $this->file_active,
            'slug' => $this->slug,
        ];
    }
}
