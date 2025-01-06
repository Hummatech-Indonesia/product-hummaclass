<?php

namespace App\Http\Controllers\Course;

use App\Contracts\Interfaces\Course\CourseInterface;
use App\Contracts\Interfaces\Course\UserCourseInterface;
use App\Helpers\CourcePercentaceHelper;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserCourseResource;
use App\Models\Course;
use App\Models\Module;
use App\Models\SubModule;
use App\Models\User;
use App\Models\UserCourse;
use App\Services\UserCourseService;
use App\Traits\PaginationTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserCourseController extends Controller
{
    use PaginationTrait;

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
    public function index(Request $request): JsonResponse
    {
        $userCourses = $this->userCourse->customPaginate($request);
        $data['paginate'] = $this->customPaginate($userCourses->currentPage(), $userCourses->lastPage());
        $data['data'] = UserCourseResource::collection($userCourses);
        return ResponseHelper::success($data, trans('alert.fetch_success'));
    }

    /**
     * guest
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function guest(Request $request): JsonResponse
    {
        $request->merge(['user_id' => auth()->user()->id]);
        $userCourses = $this->userCourse->customPaginate($request);
        $data['paginate'] = $this->customPaginate($userCourses->currentPage(), $userCourses->lastPage());
        $data['data'] = UserCourseResource::collection($userCourses);
        return ResponseHelper::success($data, trans('alert.fetch_success'));
    }

    /**
     * getByUser
     *
     * @param  mixed $request
     * @param  mixed $user
     * @return JsonResponse
     */
    public function getByUser(Request $request, User $user): JsonResponse
    {
        $request->merge(['user_id' => $user->id]);
        $userCourses = $this->userCourse->customPaginate($request);
        $data['paginate'] = $this->customPaginate($userCourses->currentPage(), $userCourses->lastPage());
        $data['data'] = UserCourseResource::collection($userCourses);
        return ResponseHelper::success($data, trans('alert.fetch_success'));
    }

    /**
     * updateLastStepUser
     *
     * @return JsonResponse
     */
    public function userLastStep(string $slug, SubModule $subModule): JsonResponse
    {
        $course = $this->course->showWithSlugWithoutRequest($slug);
        $userCourse = UserCourseResource::make($this->userCourse->showByCourse($course->id));
        $userCourse->course->test_id = $course->courseTest->id;
        $this->service->userLastStep($course, $subModule);
        return ResponseHelper::success($userCourse, 'Berhasil masuk materi');
    }

    public function checkPayment(Request $request)
    {
        $userCourse = UserCourse::with('subModule')->where('user_id', auth()->user()->id)->whereRelation('course', 'slug', $request->course_slug)->first();
        if ($userCourse) {
            return ResponseHelper::success(['user_course' => UserCourseResource::make($userCourse)]);
        } else {
            return ResponseHelper::error(['user_course' => $userCourse, 'course' => Course::with(['modules.subModules'])->where('slug', $request->course_slug)->first()]);
        }
    }
}
