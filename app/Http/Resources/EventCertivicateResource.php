<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventCertivicateResource extends JsonResource
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
            'code' => $this->code,
            'username' => $this->username,
            'event' => [
                'id' => $this->userEvent->event->id,
                'title' => $this->userEvent->event->title,
                'slug' => $this->userEvent->event->slug,
            ],
            'user_event' => [
                'id' => $this->userEvent->id,
                'has_downloaded' => $this->userEvent->has_downloaded,
            ],
            'created_at' => $this->created_at,
        ];
    }
}
