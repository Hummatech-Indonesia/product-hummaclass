<?php

namespace App\Http\Resources;

use App\Http\Resources\Course\ModuleResource;
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
        $createdAt = $this->created_at;
        $now = now();

        return [
            'id' => $this->id,
            'discussion_title' => $this->discussion_title,
            'discussion_question' => $this->discussion_question,
            'module' => ModuleResource::make($this->module),
            'discussion_answers_count' => $this->discussionAnswers->count(),
            'discussion_tags' => $this->discussionTags ? DiscussionTagResource::collection($this->discussionTags) : null,
            'time_ago' => $this->calculateTimeAgo($createdAt, $now),
        ];
    }

    /**
     * Calculate time difference as "X months/weeks/days ago".
     *
     * @param  \Illuminate\Support\Carbon  $createdAt
     * @param  \Illuminate\Support\Carbon  $now
     * @return string
     */
    private function calculateTimeAgo($createdAt, $now): string
    {
        $monthsAgo = $now->diffInMonths($createdAt);
        $weeksAgo = $now->diffInWeeks($createdAt);
        $daysAgo = $now->diffInDays($createdAt);

        if ($monthsAgo > 0) {
            return "$monthsAgo bulan lalu";
        } elseif ($weeksAgo > 0) {
            return "$weeksAgo minggu lalu";
        } elseif ($daysAgo > 0) {
            return "$daysAgo hari lalu";
        } else {
            return "Hari ini";
        }
    }
}
