<?php

namespace App\Http\Controllers\Course;

use App\Contracts\Interfaces\Course\CourseTaskInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseTaskRequest;
use App\Http\Resources\CourseTaskResource;
use App\Models\Course;
use App\Models\CourseTask;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CourseTaskController extends Controller
{
    private CourseTaskInterface $courseTask;
    /**
     * Method __construct
     *
     * @param CourseTaskInterface $courseTask [explicite description]
     *
     * @return void
     */
    public function __construct(CourseTaskInterface $courseTask)
    {
        $this->courseTask = $courseTask;
    }
    /**
     * Method index
     *
     * @param Course $course [explicite description]
     *
     * @return JsonResponse
     */
    public function index(Course $course): JsonResponse
    {
        $courseTasks = $this->courseTask->getWhere(['course_id' => $course->id]);
        return ResponseHelper::success(CourseTaskResource::collection($courseTasks), trans('alert.fetch_success'));
    }
    /**
     * Method store
     *
     * @param CourseTaskRequest $request [explicite description]
     * @param Course $course [explicite description]
     *
     * @return JsonResponse
     */
    public function store(CourseTaskRequest $request, Course $course): JsonResponse
    {
        $data = $request->validated();
        $data['course_id'] = $course->id;
        $this->courseTask->store($data);
        return ResponseHelper::success(true, trans('alert.add_success'));
    }
    /**
     * Method update
     *
     * @param CourseTaskRequest $request [explicite description]
     * @param CourseTask $courseTask [explicite description]
     *
     * @return JsonResponse
     */
    public function update(CourseTaskRequest $request, CourseTask $courseTask): JsonResponse
    {
        $this->courseTask->update($courseTask->id, $request->validated());
        return ResponseHelper::success(true, trans('alert.update_success'));
    }
    /**
     * Method destroy
     *
     * @param CourseTask $courseTask [explicite description]
     *
     * @return JsonResponse
     */
    public function destroy(CourseTask $courseTask): JsonResponse
    {
        try {
            $this->courseTask->delete($courseTask->id);
            return ResponseHelper::success(true, trans('alert.delete_success'));
        } catch (\Throwable $e) {
            return ResponseHelper::success(true, trans('alert.delete_constrained'));
        }
    }
}
