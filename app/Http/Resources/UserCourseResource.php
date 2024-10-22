<?php

namespace App\Http\Resources;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserCourseResource extends JsonResource
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
            'course' => $this->course,
            'has_post_test' => $this->has_post_test,
            'has_pre_test' => $this->has_pre_test,
            'sub_module_slug' => $this->subModule->slug
        ];
    }
}
