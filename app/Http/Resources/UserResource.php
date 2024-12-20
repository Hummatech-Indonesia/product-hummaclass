<?php

namespace App\Http\Resources;

use App\Enums\TestEnum;
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
            'photo' => url('storage/' . $this->photo),
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'user_courses' => $this->userCourses,
            'total_courses' => $this->userCourses->count(),
            'total_reviews' => $this->courseReviews->count(),
            'course_reviews' => ReviewResource::collection($this->courseReviews),
            // 'total_course_completed' => $this->userCourseTests()->where('type_test', TestEnum::POSTTEST->value)->whereNotNull('score')->count(),
            'total_certificate' => $this->userEvents()->where('has_certificate', true)->count(),
            'course_activities' => $this->userCourses ? UserCourseResource::collection($this->userCourses) : null,
            'event_activities' => $this->userEvents ? UserEventResource::collection($this->userEvents) : null,
            'address' => $this->address,
            'banner' => url('storage/' . $this->banner),
            'gender' => $this->gender,
            'created' => Carbon::parse($this->created_at)->format('d F Y'),
        ];
    }
}
