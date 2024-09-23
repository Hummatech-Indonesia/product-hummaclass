<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
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
            'user' => new UserResource($this->user),
            'sub_category' => $this->subCategory->name,
            'category' => $this->subCategory->category->name,
            'title' => $this->title,
            'sub_title' => $this->sub_title,
            'description' => $this->description,
            'slug' => $this->slug,
            'is_premium' => $this->is_premium,
            'price' => $this->price,
            'photo' => url('storage/' . $this->photo),
            'modules_count' => $this->modules->count(),
            'rating' => $this->courseReviews->avg('rating'),
            'course_reviews' => CourseReviewResource::collection($this->courseReviews),
            'course_review_count' => $this->courseReviews->count(),
            'user_courses_count' => $this->userCourses->count(),
            'created' => $this->created_at->format('d/m/Y'),
        ];
    }
}
