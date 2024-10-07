<?php

namespace App\Http\Controllers\Course;

use App\Contracts\Interfaces\Course\CourseInterface;
use App\Contracts\Interfaces\Course\UserCourseInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserCourseResource;
use App\Models\Course;
use App\Models\Module;
use App\Models\SubModule;
use App\Services\UserCourseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserCourseController extends Controller
{
    private UserCourseInterface $userCourse;
    private CourseInterface $course;
    private UserCourseService $service;
    public function __construct(UserCourseInterface $userCourse, UserCourseService $service, CourseInterface $course)
    {
        $this->userCourse = $userCourse;
        $this->course = $course;
        $this->service = $service;
    }

    /**
     * index
     *
     * @param  mixed $request
     * @param  mixed $course
     * @return JsonResponse
     */
    public function index(Request $request, Course $course): JsonResponse
    {
        $request->merge(['course_id' => $course->id]);
        $userCourses = $this->userCourse->customPaginate($request);
        return ResponseHelper::success(UserCourseResource::collection($userCourses), trans('alert.fetch_success'));
    }


    /**
     * updateLastStepUser
     *
     * @return JsonResponse
     */
    public function userLastStep(string $slug, SubModule $subModule): JsonResponse
    {
        $course = $this->course->showWithSlug($slug);
        $this->service->userLastStep($course, $subModule);
        return ResponseHelper::success(null, 'Berhasil masuk materi');
    }
}
