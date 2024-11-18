<?php

namespace App\Http\Resources\Course;

use App\Helpers\CourcePercentaceHelper;
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

        $totalReviews = $this->courseReviews->count();

        $ratingsCount = collect([
            5 => $this->courseReviews->where('rating', 5)->count(),
            4 => $this->courseReviews->where('rating', 4)->count(),
            3 => $this->courseReviews->where('rating', 3)->count(),
            2 => $this->courseReviews->where('rating', 2)->count(),
            1 => $this->courseReviews->where('rating', 1)->count(),
        ]);

        $ratingsPercentage = $ratingsCount->mapWithKeys(function ($count, $rating) use ($totalReviews) {
            return [$rating => $totalReviews > 0 ? round(($count / $totalReviews) * 100, 2) : 0];
        });

        $userCource = $this->userCourses()?->where('user_id', $user?->id)->with('subModule')->first();
        if ($userCource && $user) {
            $completed = CourcePercentaceHelper::getPercentace($userCource);
        } else {
            $completed = null;
        }

        return [
            'id' => $this->id,
            'user_course' => $userCource,
            'completed' => $completed,
            'course_test_id' => $this->courseTest?->id,
            'sub_category' => SubCategoryResource::make($this->subCategory),
            'category' => CategoryResource::make($this->subCategory->category),
            'title' => $this->title,
            'sub_title' => $this->sub_title,
            'description' => $this->description,
            'slug' => $this->slug,
            'is_premium' => $this->is_premium,
            'price' => $this->price,
            'promotional_price' => $this->promotional_price,
            'ratings' => $ratingsCount,
            'ratings_percentage' => $ratingsPercentage,
            'rating' => number_format($this->courseReviews->avg('rating'), 1) ?? 0,
            'photo' => url('storage/' . $this->photo),
            'modules' => ModuleResource::collection($this->modules),
            'modules_count' => $this->modules->count(),
            'course_reviews' => CourseReviewResource::collection($this->courseReviews),
            'course_review_count' => $this->courseReviews->count(),
            'user_courses_count' => $this->userCourses->count(),
            'created' => $this->created_at,
            'is_admin' => $user?->hasRole('admin'),
        ];
    }
}
