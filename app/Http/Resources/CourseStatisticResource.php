<?php

namespace App\Http\Resources;

use App\Enums\TestEnum;
use App\Services\Course\CourseService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class CourseStatisticResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $transactions = $this->transactions;

        $groupedTransactions = $transactions->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('m');
        });

        $groupedTransactionsWithMonthName = $groupedTransactions->mapWithKeys(function ($items, $key) {
            // dd($items->sum('amount'));
            $monthName = Carbon::createFromFormat('m', $key)->locale('id')->isoFormat('MMMM');
            $monthNameLowerCase = strtolower($monthName);
            return [$monthNameLowerCase => $items->sum('amount')];
        });

        return [
            'total_purchases' => $this->userCourses ? $this->userCourses()->count() : 0,
            'total_revenue' => optional($this->userCourses->first())->course->price ?? 0,
            'total_tasks' => $this->modules()->withCount('moduleTasks'),
            'completed' => $this->userCourses()->whereNotNull('has_post_test')->count(),
            'transaction' => $groupedTransactionsWithMonthName,
            'pre_test_average' => $this->courseTests()->with('userCourseTests', function ($query) {
                return $query->where('type_test', TestEnum::PRETEST->value)->avg('score');
            }) ?? 0,
            'post_test_average' => $this->courseTests()->with('userCourseTests', function ($query) {
                return $query->where('type_test', TestEnum::POSTTEST->value)->avg('score');
            }) ?? 0,
            'rating_count' => $this->courseReviews()->count(),
            'average_rating' => $this->courseReviews->avg('rating') ?? 0,
            'ratings_distribution' => collect([1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0])
                ->merge(
                    $this->courseReviews->groupBy('rating')
                        ->map(fn($group) => $group->count())
                )->all(),
        ];
    }
}
