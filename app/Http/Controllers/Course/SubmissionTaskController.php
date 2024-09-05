<?php

namespace App\Http\Controllers\Course;

use App\Contracts\Interfaces\Course\SubmissionTaskInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseTaskRequest;
use App\Http\Requests\SubmissionTaskRequest;
use App\Models\CourseTask;
use App\Models\SubmissionTask;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubmissionTaskController extends Controller
{
    private SubmissionTaskInterface $submissionTask;
    /**
     * Method __construct
     *
     * @param SubmissionTaskInterface $submissionTask [explicite description]
     *
     * @return void
     */
    public function __construct(SubmissionTaskInterface $submissionTask)
    {
        $this->submissionTask = $submissionTask;
    }
    /**
     * Method index
     *
     * @param CourseTask $courseTask [explicite description]
     *
     * @return JsonResponse
     */
    public function index(CourseTask $courseTask): JsonResponse
    {
        $submissionTasks = $this->submissionTask->getWhere(['course_task_id' => $courseTask->id]);
        return ResponseHelper::success($submissionTasks, trans('alert.fetch_success'));
    }
    /**
     * Method store
     *
     * @param SubmissionTaskRequest $request [explicite description]
     * @param CourseTask $courseTask [explicite description]
     *
     * @return JsonResponse
     */
    public function store(SubmissionTaskRequest $request, CourseTask $courseTask): JsonResponse
    {
        $data = $request->validated();
        $data['course_task_id'] = $courseTask->id;
        $this->submissionTask->store($data);
        return ResponseHelper::success(true, trans('alert.add_success'));
    }
    /**
     * Method update
     *
     * @param SubmissionTaskRequest $request [explicite description]
     * @param SubmissionTask $submissionTask [explicite description]
     *
     * @return JsonResponse
     */
    public function update(SubmissionTaskRequest $request, SubmissionTask $submissionTask): JsonResponse
    {
        $this->submissionTask->update($submissionTask->id, $request->validated());
        return ResponseHelper::success(true, trans('alert.update_success'));
    }
    /**
     * Method destroy
     *
     * @param SubmissionTask $submissionTask [explicite description]
     *
     * @return JsonResponse
     */
    public function destroy(SubmissionTask $submissionTask): JsonResponse
    {
        $this->submissionTask->delete($submissionTask->id);
        return ResponseHelper::success(true, trans('alert.delete_success'));
    }
}
