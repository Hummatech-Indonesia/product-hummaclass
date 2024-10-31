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
            'user' => $this->user,
            'is_attendance' => $this->is_attendance,
            'created_at' => Carbon::parse($this->created_at)->isoFormat('DD MMMM YYYY'),
        ];
    }
}
