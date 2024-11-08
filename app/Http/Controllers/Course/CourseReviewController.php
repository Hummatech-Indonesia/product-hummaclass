<?php

namespace App\Http\Controllers\Course;

use App\Contracts\Interfaces\Course\CourseReviewInterface;
use App\Contracts\Interfaces\Course\UserCourseInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseReviewRequest;
use App\Http\Resources\CourseReviewResource;
use App\Models\Course;
use App\Models\CourseReview;
use App\Models\User;
use App\Models\UserCourse;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CourseReviewController extends Controller
{
    private CourseReviewInterface $courseReview;
    private UserCourseInterface $userCoruse;
    /**
     * Method __construct
     *
     * @param CourseReviewInterface $courseReview [explicite description]
     *
     * @return void
     */
    public function __construct(CourseReviewInterface $courseReview, UserCourseInterface $userCoruse)
    {
        $this->courseReview = $courseReview;
        $this->userCoruse = $userCoruse;
    }
    /**
     * Method index
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $courseReview = $this->courseReview->get();
        return ResponseHelper::success(CourseReviewResource::collection($courseReview), trans('alert.fetch_success'));
    }
    /**
     * Method getLatest
     *
     * @return JsonResponse
     */
    public function getLatest(): JsonResponse
    {
        $courseReviews = $this->courseReview->getLatest();
        return ResponseHelper::success(CourseReviewResource::collection($courseReviews), trans('alert.fetch_success'));
    }
    /**
     * Method store
     *
     * @param CourseReviewRequest $request [explicite description]
     * @param Course $course [explicite description]
     *
     * @return mixed
     */
    public function store(CourseReviewRequest $request, Course $course): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        $data['course_id'] = $course->id;
        $userCourse = $this->userCoruse->showByCourse($course->id);
        $updated_at = Carbon::make($userCourse->updated_at);
        if ($userCourse->has_post_test && $updated_at->diffInMonths(Carbon::now())) {
            return ResponseHelper::success(false, trans('alert.review_expired'));
        }
        $this->courseReview->store($data);
        return ResponseHelper::success(true, trans('alert.add_success'));
    }
    /**
     * Method show
     *
     * @param CourseReview $courseReview [explicite description]
     *
     * @return JsonResponse
     */
    public function show(CourseReview $courseReview): JsonResponse
    {
        $courseReview = $this->courseReview($courseReview->id);
        return ResponseHelper::success(new CourseReviewResource($courseReview), trans('alert.fetch_success'));
    }
    /**
     * Method update
     *
     * @param CourseReviewRequest $request [explicite description]
     * @param CourseReview $courseReview [explicite description]
     *
     * @return JsonResponse
     */
    public function update(CourseReviewRequest $request, CourseReview $courseReview): JsonResponse
    {
        $this->courseReview->update($courseReview->id, $request->validated());
        return ResponseHelper::success(true, trans('alert.update_success'));
    }

    public function latest(): JsonResponse
    {
        $courseReview = $this->courseReview->latest(3);
        return ResponseHelper::success($courseReview, trans('alert.fetch_success'));
    }
}
