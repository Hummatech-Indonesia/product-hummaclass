<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
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
            'school' => $this->classroom->school->name,
            'school_id' => $this->classroom->school->id,
            'classroom_id' => $this->classroom_id,
            'classroom' => $this->classroom->name,
            'date' => Carbon::parse($this->created_at)->translatedFormat('d F Y'),
            'status' => $this->status,
        ];
    }
}
