<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DiscussionAnswerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'answer' => $this->answer,
            'discussion_answer' => $this->discussionAnswer,
            'discussion' => $this->discussion,
            'user' => UserResource::make($this->user),
            'time_ago' => Carbon::parse($this->created_at)->diffForHumans(),
        ];
    }
}
