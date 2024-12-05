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
            'school' => $this->classroom->school->name,
            'classroom_id' => $this->classroom->id,
            'classroom' => $this->classroom->name,
            'date' => Carbon::parse($this->created_at)->translatedFormat('d F Y'),
            'status' => $this->status,
        ];
    }
}
