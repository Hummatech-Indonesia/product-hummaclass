<?php

namespace App\Http\Resources;

use App\Enums\TestEnum;
use App\Models\UserCourseTest;
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
            $monthName = Carbon::createFromFormat('m', $key)->locale('id')->isoFormat('MMMM');
            $monthNameLowerCase = strtolower($monthName);
            return [$monthNameLowerCase => $items->sum('amount')];
        });

        // Calculating pre-test and post-test averages
        $preTestAvg = UserCourseTest::whereIn('course_test_id', $this->courseTests->pluck('id'))
            ->where('test_type', TestEnum::PRETEST->value)
            ->avg('score');

        $postTestAvg = UserCourseTest::whereIn('course_test_id', $this->courseTests->pluck('id'))
            ->where('test_type', TestEnum::POSTTEST->value)
            ->avg('score');

        // Sequential scores for statistics
        $preTestScores = UserCourseTest::whereIn('course_test_id', $this->courseTests->pluck('id'))
            ->where('test_type', TestEnum::PRETEST->value)
            ->orderBy('created_at')
            ->pluck('score')
            ->toArray();

        $postTestScores = UserCourseTest::whereIn('course_test_id', $this->courseTests->pluck('id'))
            ->where('test_type', TestEnum::POSTTEST->value)
            ->orderBy('created_at')
            ->pluck('score')
            ->toArray();

        $totalRatings = $this->courseReviews()->count();
        $ratingsDistribution = collect([1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0])
            ->merge(
                $this->courseReviews->groupBy('rating')
                    ->map(fn($group) => $group->count())
            );

        // Calculate percentage distribution for each rating
        $ratingsPercentageDistribution = $ratingsDistribution->map(function ($count) use ($totalRatings) {
            return $totalRatings > 0 ? round(($count / $totalRatings) * 100, 2) : 0;
        });

        return [
            'total_purchases' => $this->userCourses ? $this->userCourses()->count() : 0,
            'total_revenue' => optional($this->userCourses->first())->course->price ?? 0,
            'total_tasks' => $this->modules()->withCount('moduleTasks'),
            'completed' => $this->userCourses()->whereNotNull('has_post_test')->count(),

            'transaction' => $groupedTransactionsWithMonthName,

            'pre_test_average' => number_format($preTestAvg, 1),
            'post_test_average' => number_format($postTestAvg, 1),
            'rating_count' => $totalRatings,
            'average_rating' => $this->courseReviews->avg('rating') ?? 0,

            'ratings_distribution' => $ratingsDistribution->all(),
            'ratings_percentage_distribution' => $ratingsPercentageDistribution->all(),

            // Adding sequential score arrays for statistics
            'score_average' => UserCourseTest::whereIn('course_test_id', $this->courseTests->pluck('id'))->avg('score'),
            'pre_test_score_distribution' => $preTestScores,
            'post_test_score_distribution' => $postTestScores,
        ];
    }
}
