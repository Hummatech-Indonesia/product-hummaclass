<?php

namespace App\Http\Resources;

use App\Http\Resources\IndustryClass\ClassroomResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JournalPresenceResource extends JsonResource
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
            'status' => $this->status == 'present' ? 'Hadir' : ($this->status == 'alpha' ? 'Alpha' : ($this->status == 'sick' ? 'Sakit' : ($this->status == 'permit' ? 'Izin' : ''))),
            'detail_bg' => $this->status == 'present' ? 'bg-light-success text-success' : ($this->status == 'alpha' ? 'bg-light-danger text-danger' : ($this->status == 'sick' ? 'bg-light-primary text-primary' : ($this->status == 'permit' ? 'bg-light-warning text-warning' : ''))),
            'student' => StudentResource::make($this->studentClassroom->student),
        ];
    }
}
