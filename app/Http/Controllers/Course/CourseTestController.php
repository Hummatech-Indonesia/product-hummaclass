<?php

namespace App\Http\Controllers\Course;

use App\Contracts\Interfaces\Course\CourseTestInterface;
use App\Contracts\Interfaces\UserCourseTestInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseTestRequest;
use App\Http\Resources\CourseTestResource;
use App\Http\Resources\UserCourseTestResource;
use App\Models\Course;
use App\Models\CourseTest;
use App\Services\CourseTestService;
use App\Traits\PaginationTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CourseTestController extends Controller
{
    use PaginationTrait;
    private CourseTestInterface $courseTest;
    private UserCourseTestInterface $userCourseTest;
    private CourseTestService $service;
    public function __construct(CourseTestInterface $courseTest, CourseTestService $service, UserCourseTestInterface $userCourseTest)
    {
        $this->courseTest = $courseTest;
        $this->userCourseTest = $userCourseTest;
        $this->service = $service;
    }
    public function index(Course $course): JsonResponse
    {
        $courseTest = $this->courseTest->show($course->id);
        return ResponseHelper::success(CourseTestResource::make($courseTest), trans('alert.fetch_success'));
    }
    public function show(Request $request, CourseTest $courseTest): JsonResponse
    {
        $this->service->store($courseTest);
        $request->merge(['course_id' => $courseTest->id]);
        $userCourseTests = $this->userCourseTest->customPaginate($request);
        $data['paginate'] = $this->customPaginate($userCourseTests->currentPage(), $userCourseTests->lastPage());
        $data['data'] = UserCourseTestResource::collection($userCourseTests);
        return responsehelper::success($data, trans('alert.fetch_success'));
    }
    public function get(): JsonResponse
    {
        $courseTests = $this->courseTest->get();
        return ResponseHelper::success(CourseTestResource::collection($courseTests), trans('alert.fetch_success'));
    }
    public function store(CourseTestRequest $request, Course $course): JsonResponse
    {
        $data = $request->validated();
        $data['course_id'] = $course->id;
        $this->courseTest->store($data);
        return ResponseHelper::success(true, trans('alert.add_success'));
    }
}
