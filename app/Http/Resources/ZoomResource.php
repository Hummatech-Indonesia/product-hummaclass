<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ZoomResource extends JsonResource
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
            'school' => $this->school,
            'classroom' => $this->classroom,
            'mentor' => $this->mentor,
            'date' => $this->date->format('Y-m-d H:i:s'),
            'link' => $this->link
        ];
    }
}
