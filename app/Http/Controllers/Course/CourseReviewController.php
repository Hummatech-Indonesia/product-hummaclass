<?php

namespace App\Http\Controllers\Course;

use App\Contracts\Interfaces\Course\CourseReviewInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseReviewRequest;
use App\Models\User;
use App\Models\UserCourse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CourseReviewController extends Controller
{
    private CourseReviewInterface $courseReview;
    /**
     * Method __construct
     *
     * @param CourseReviewInterface $courseReview [explicite description]
     *
     * @return void
     */
    public function __construct(CourseReviewInterface $courseReview)
    {
        $this->courseReview = $courseReview;
    }
    public function store(CourseReviewRequest $request, UserCourse $userCourse): JsonResponse
    {
        $data = $request->validated();
        $data['user_course_id']->$userCourse->id;
        if ($userCourse->user_id == $request->user()->id) {
            $this->courseReview->store($data);
            return ResponseHelper::success(trans('alert.add_review'));
        } else {
            return ResponseHelper::error(trans('alert.add_failed'));
        }
    }
}
