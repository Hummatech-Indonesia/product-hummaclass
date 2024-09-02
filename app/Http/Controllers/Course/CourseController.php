<?php

namespace App\Http\Controllers\Course;

use App\Contracts\Interfaces\Course\CourseInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Models\Course;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    private CourseInterface $course;    
    /**
     * Method __construct
     *
     * @param CourseInterface $course [explicite description]
     *
     * @return void
     */
    public function __construct(CourseInterface $course)
    {
        $this->course = $course;
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
        $this->course->store($request->validated());
        return ResponseHelper::success(trans('alert.add_success'));
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
        return ResponseHelper::success(trans('alert.update_success'));
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
            return ResponseHelper::success(trans('alert.delete_success'));
        } catch (\Throwable $e) {
            return ResponseHelper::success(trans('alert.delete_constrained'));
        }
    }
}
