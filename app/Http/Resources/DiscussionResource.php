<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DiscussionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return ['woi','halo'];
        return [
            'id' => $this->id,
            'discussion_title' => $this->discussion_title,
            'discussion_question' => $this->discussion_question,
            'module' => $this->module,
            'discussion_answers' => $this->discussionAnswer ? DiscussionAnswerResource::collection($this->discussionAnswer) : null,
            'discussion_tags' => $this->discussionTags ? DiscussionTagResource::collection($this->discussionTags) : null
        ];
    }
}
