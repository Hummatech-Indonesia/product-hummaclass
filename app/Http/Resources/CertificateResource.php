<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CertificateResource extends JsonResource
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
            'code' => $this->code,
            'username' => $this->username,
            'course' => [
                'id' => $this->userCourse->course->id,
                'title' => $this->userCourse->course->title,
                'slug' => $this->userCourse->course->slug,
            ],
            'user_course' => [
                'id' => $this->userCourse->id,
                'has_downloaded' => $this->userCourse->has_downloaded,
            ],
            'created_at' => $this->created_at,
            'expired' => $this->created_at instanceof \Carbon\Carbon
                ? $this->created_at->copy()->addYears(4)
                : null,
        ];
    }
}
