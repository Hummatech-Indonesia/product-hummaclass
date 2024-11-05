<?php

namespace App\Http\Resources;

use App\Enums\TestEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseStatisticResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'total_purchases' => $this->userCourses ? $this->userCourses()->count() : 0,
            'total_revenue' => optional($this->userCourses->first())->course->price ?? 0,
            'total_tasks' => $this->modules()->withCount('moduleTasks'),
            'completed' => $this->userCourses()->whereNotNull('has_post_test')->count(),
            'pre_test_average' => $this->courseTests()->with('userCourseTests', function ($query) {
                return $query->where('type_test', TestEnum::PRETEST->value)->avg('score');
            }) ?? 0,
            'post_test_average' => $this->courseTests()->with('userCourseTests', function ($query) {
                return $query->where('type_test', TestEnum::POSTTEST->value)->avg('score');
            }) ?? 0,
            'average_rating' => $this->courseReviews->avg('rating') ?? 0,
            'ratings_distribution' => collect([1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0])
                ->merge(
                    $this->courseReviews->groupBy('rating')
                        ->map(fn($group) => $group->count())
                )->all(),
        ];
    }
}
