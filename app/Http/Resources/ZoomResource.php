<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ZoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'school' => $this->school,
            'classroom' => $this->classroom,
            'mentor' => $this->mentor,
            'date' => Carbon::parse($this->date)->format('Y-m-d'),
            'link' => $this->link,
        ];
    }
}
