<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;


class UserResource extends JsonResource
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
            'photo' => asset('storage/' . $this->photo),
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'total_courses' => $this->userCourses->count(),
            'total_course_completed' => $this->userCourseTests()->whereNotNull('post_test_score')->count(),
            'total_certificate' => $this->eventUsers()->where('is_certificated', true)->count(),
            'course_activities' => $this->userCourses ? CourseResource::collection($this->userCourses) : null,
            'event_activities' => $this->eventUsers ? EventResource::collection($this->eventUsers) : null,
            'address' => $this->address,
            'gender' => $this->gender,
            'created' => Carbon::parse($this->created_at)->format('d F Y'),
        ];
    }
}
