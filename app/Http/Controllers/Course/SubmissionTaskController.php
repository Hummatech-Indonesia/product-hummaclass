<?php

namespace App\Http\Controllers\Course;

use App\Models\CourseTask;
use App\Models\ModuleTask;
use Illuminate\Http\Request;
use App\Models\SubmissionTask;
use App\Helpers\ResponseHelper;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\SubmissionTaskService;
use App\Http\Requests\CourseTaskRequest;
use App\Http\Requests\SubmissionTaskRequest;
use App\Contracts\Interfaces\Course\SubmissionTaskInterface;
use App\Http\Resources\ModuleTaskResource;
use App\Http\Resources\ShowSubmissionTaskResource;
use App\Http\Resources\SubmissionTaskResource;
use Illuminate\Support\Facades\Storage;

class SubmissionTaskController extends Controller
{
    private SubmissionTaskInterface $submissionTask;
    private SubmissionTaskService $service;
    /**
     * Method __construct
     *
     * @param SubmissionTaskInterface $submissionTask [explicite description]
     *
     * @return void
     */
    public function __construct(SubmissionTaskInterface $submissionTask, SubmissionTaskService $service)
    {
        $this->submissionTask = $submissionTask;
        $this->service = $service;
    }
    /**
     * Method index
     *
     * @param ModuleTask $moduleTask [explicite description]
     *
     * @return JsonResponse
     */
    public function index(ModuleTask $moduleTask): JsonResponse
    {
        $submissionTasks = $this->submissionTask->getWhere(['module_task_id' => $moduleTask->id]);
        return ResponseHelper::success(SubmissionTaskResource::collection($submissionTasks), trans('alert.fetch_success'));
    }
        
    /**
     * show
     *
     * @param  mixed $submissionTask
     * @return JsonResponse
     */
    public function show(SubmissionTask $submissionTask): JsonResponse
    {
        return ResponseHelper::success(ShowSubmissionTaskResource::make($submissionTask), trans('alert.fetch_success'));
    }
    /**
     * Method store
     *
     * @param SubmissionTaskRequest $request [explicite description]
     * @param ModuleTask $moduleTask [explicite description]
     *
     * @return JsonResponse
     */
    public function store(SubmissionTaskRequest $request, ModuleTask $moduleTask)
    {
        $data = $request->validated();
        $data['module_task_id'] = $moduleTask->id;
        $data['user_id'] = auth()->user()->id;
        $data['file'] = $this->service->handleStoreFile($request);
        $stored = $this->submissionTask->store($data);
        if ($stored['status'] == "failed") {
            $this->service->handleRemoveFile($data['file']);
        } else {
            if ($stored['status'] == "created") {
                $this->service->handleAddPoint();
            } else {
                $this->service->handleRemoveFile($data['file']);
            }
        }
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

    public function download(SubmissionTask $submissionTask): mixed
    {
        $exist = $this->service->exist($submissionTask->file);
        if ($exist) {
            return response()->download(storage_path('app/public/' . $submissionTask->file));
        }
        return view('errors.file-notfound');
    }
}
