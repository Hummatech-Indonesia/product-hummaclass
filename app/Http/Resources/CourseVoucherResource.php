<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseVoucherResource extends JsonResource
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
            'course' => $this->course->title,
            'usage_limit' => $this->usage_limit,
            'discount' => $this->discount,
            'code' => $this->code,
            'users' => $this->courseVoucherUsers,
        ];
    }
}
