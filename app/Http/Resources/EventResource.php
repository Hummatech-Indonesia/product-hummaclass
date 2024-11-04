<?php

namespace App\Http\Resources;

use Carbon\Carbon;
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
        // Calculate days until the event starts
        $day = now()->diffInDays(Carbon::parse($this->start_date));
        $start_in = now()->greaterThan($this->start_date)
            ? 'Sudah dimulai'
            : (Carbon::parse($this->start_date)->isFuture()
                ? ($day > 0 ? $day . " hari lagi" : "hari ini")
                : '');

        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'price' => $this->price,
            'location' => $this->location,
            'capacity' => $this->capacity,
            'capacity_left' => $this->capacity - $this->userEvents()->count(),
            'has_certificate' => $this->has_certificate,
            'is_online' => $this->is_online,
            'start_date' => Carbon::parse($this->start_date)->translatedFormat('j F Y'),
            'end_date' => Carbon::parse($this->end_date)->translatedFormat('j F Y'),
            'image' => url('storage/' . $this->image),
            'event_details' => $this->eventDetails,
            'start_in' => $start_in, // Add the start_in field here
            'created_at' => $this->created_at,
        ];
    }

}
