<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserEventAttendanceResource extends JsonResource
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
            'attendance_date' => $this->eventAttendance->attendance_date,
            'attendance_day' => Carbon::parse($this->eventAttendance->attendance_date)->locale('id_ID')->isoFormat('dddd'),
            'created' => $this->created_at->format('H:i'),
            'updated' => $this->updated_at->format('H:i'),
            'status' => $this->is_attendance === true ? 'Hadir' : 'Tidak Hadir'
        ];
    }
}
