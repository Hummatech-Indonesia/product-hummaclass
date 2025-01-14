<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JournalResource extends JsonResource
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
            'description' => $this->description,
            'image' => url('storage/' . $this->image),
            'user' => $this->user,
            'classroom' => $this->classroom,
            'date' => Carbon::parse($this->created_at)->translatedFormat('d F Y - H:i'),
            'student_presence' => JournalPresenceResource::collection($this->journalPresences)
        ];
    }
}
