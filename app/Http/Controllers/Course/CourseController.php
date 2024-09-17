<?php

namespace App\Http\Controllers\Course;

use App\Contracts\Interfaces\Course\CourseInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Http\Resources\Course\DetailCourseResource;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use App\Services\Course\CourseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    private CourseInterface $course;
    private CourseService $service;



    /**
     * Method __construct
     *
     * @param CourseInterface $course [explicite description]
     *
     * @return void
     */
    public function __construct(CourseInterface $course, CourseService $service)
    {
        $this->course = $course;
        $this->service = $service;
    }

    public function index(Request $request): JsonResponse
    {
        $courses = $this->course->customPaginate($request);
        return ResponseHelper::success(CourseResource::collection($courses), trans('alert.fetch_success'));
    }

    /**
     * Method store
     *
     * @param CourseRequest $request [explicite description]
     *
     * @return JsonResponse
     */
    public function store(CourseRequest $request): JsonResponse
    {
        $this->course->store($this->service->store($request));
        return ResponseHelper::success(true, trans('alert.add_success'));
    }
    /**
     * Method show
     *
     * @param Course $course [explicite description]
     *
     * @return JsonResponse
     */
    public function show(Course $course): JsonResponse
    {
        $course = $this->course->show($course->id);
        return ResponseHelper::success(DetailCourseResource::make($course), trans('alert.fetch_success'));
    }

    /**
     * Method update
     *
     * @param CourseRequest $request [explicite description]
     * @param Course $course [explicite description]
     *
     * @return JsonResponse
     */
    public function update(CourseRequest $request, Course $course): JsonResponse
    {
        $this->course->update($course->id, $request->validated());
        return ResponseHelper::success(true, trans('alert.update_success'));
    }
    /**
     * Method destroy
     *
     * @param Course $course [explicite description]
     *
     * @return JsonResponse
     */
    public function destroy(Course $course): JsonResponse
    {
        try {
            $this->course->delete($course->id);
            return ResponseHelper::success(true, trans('alert.delete_success'));
        } catch (\Throwable $e) {
            return ResponseHelper::success(true, trans('alert.delete_constrained'));
        }
    }
}
