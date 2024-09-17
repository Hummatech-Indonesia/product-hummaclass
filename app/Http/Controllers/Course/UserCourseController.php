<?php

namespace App\Http\Controllers\Course;

use App\Contracts\Interfaces\Course\UserCourseInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserCourseResource;
use App\Models\Course;
use App\Models\Module;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserCourseController extends Controller
{
    private UserCourseInterface $userCourse;
    public function __construct(UserCourseInterface $userCourse)
    {
        $this->userCourse = $userCourse;
    }
    public function index(Request $request, Course $course): JsonResponse
    {
        $request->merge(['course_id' => $course->id]);
        $userCourses = $this->userCourse->customPaginate($request);
        return ResponseHelper::success(UserCourseResource::collection($userCourses), trans('alert.fetch_success'));
    }
}
