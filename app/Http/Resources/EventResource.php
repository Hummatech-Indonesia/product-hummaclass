<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'price' => $this->price,
            'location' => $this->location,
            'capacity' => $this->capacity,
            'has_certificate' => $this->has_certificate,
            'is_online' => $this->is_online,
            'start_date' => $this->start_date,
            'image' => url('storage/' . $this->image),
            'event_details' => $this->eventDetails,
            'created_at' => $this->created_at,
        ];
    }
}
