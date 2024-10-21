<?php

namespace App\Http\Resources\Course;

use App\Http\Resources\CourseReviewResource;
use App\Http\Resources\SubCategoryResource;
use App\Http\Resources\UserResource;
use App\Models\Module;
use App\Models\SubModule;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailCourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = \Laravel\Sanctum\PersonalAccessToken::findToken(substr($request->header('authorization'), 7, 100))?->tokenable()->first();
        $userCourse = $this->userCourses->where('user_id', $user?->id)->first();
        $userCourse->sub_module_slug = SubModule::find($userCourse->sub_module_id)->slug;
        return [
            'id' => $this->id,
            'user' => new UserResource($this->user),
            'user_course' => $userCourse,
            'course_test_id' => $this->courseTest->id,
            'sub_category' => SubCategoryResource::make($this->subCategory),
            'category' => CategoryResource::make($this->subCategory->category),
            'title' => $this->title,
            'sub_title' => $this->sub_title,
            'description' => $this->description,
            'slug' => $this->slug,
            'is_premium' => $this->is_premium,
            'price' => $this->price,
            'ratings' => $this->courseReviews->groupBy('rating')->map(fn($group) => $group->count()),
            'photo' => url('storage/' . $this->photo),
            'modules' => ModuleResource::collection($this->modules),
            'modules_count' => $this->modules->count(),
            'rating' => $this->courseReviews->avg('rating'),
            'course_reviews' => CourseReviewResource::collection($this->courseReviews),
            'course_review_count' => $this->courseReviews->count(),
            'user_courses_count' => $this->userCourses->count(),
            'created' => $this->created_at->format('d/m/Y'),
        ];
    }
}
