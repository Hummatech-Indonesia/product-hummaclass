<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserEventResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $day = now()->diffInDays(Carbon::parse($this->event->start_date));
        $this->event->start_in = now()->greaterThan($this->event->start_date)
            ? $this->event->start_date
            : (Carbon::parse($this->event->start_date)->isFuture()
                ? ($day > 0 ? $day . " hari lagi" : "hari ini") : ''
            );
        $this->event->slot = $this->event->capacity - $this->event->user_events_count;

        return [
            'user' => $this->user,
            'event' => $this->event,
        ];
    }
}
