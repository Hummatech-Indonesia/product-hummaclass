<?php

namespace App\Http\Controllers\Course;

use App\Contracts\Interfaces\Course\ModuleTaskInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ModuleTaskRequest;
use App\Http\Resources\ModuleTaskResource;
use App\Models\Course;
use App\Models\Module;
use App\Models\ModuleTask;
use Illuminate\Http\JsonResponse;

class ModuleTaskController extends Controller
{
    private ModuleTaskInterface $moduleTask;
    /**
     * Method __construct
     *
     * @param ModuleTaskInterface $moduleTask [explicite description]
     *
     * @return void
     */
    public function __construct(ModuleTaskInterface $moduleTask)
    {
        $this->moduleTask = $moduleTask;
    }
    /**
     * Method index
     *
     * @param Course $course [explicite description]
     *
     * @return JsonResponse
     */
    public function index(Module $module): JsonResponse
    {
        $moduleTasks = $this->moduleTask->getWhere(['module_id' => $module->id]);
        return ResponseHelper::success(ModuleTaskResource::collection($moduleTasks), trans('alert.fetch_success'));
    }
    /**
     * Method store
     *
     * @param ModuleTaskRequest $request [explicite description]
     * @param Module $module [explicite description]
     *
     * @return JsonResponse
     */
    public function store(ModuleTaskRequest $request, Module $module): JsonResponse
    {
        $data = $request->validated();
        $data['module_id'] = $module->id;
        $this->moduleTask->store($data);
        return ResponseHelper::success(true, trans('alert.add_success'));
    }    
    /**
     * Method show
     *
     * @param ModuleTask $moduleTask [explicite description]
     *
     * @return JsonResponse
     */
    public function show(ModuleTask $moduleTask): JsonResponse
    {
        $moduleTask = $this->moduleTask->show($moduleTask->id);
        return ResponseHelper::success(ModuleTaskResource::make($moduleTask), trans('alert.fetch_success'));
    }
    /**
     * Method update
     *
     * @param ModuleTaskRequest $request [explicite description]
     * @param ModuleTask $moduleTask [explicite description]
     *
     * @return JsonResponse
     */
    public function update(ModuleTaskRequest $request, ModuleTask $moduleTask): JsonResponse
    {
        $this->moduleTask->update($moduleTask->id, $request->validated());
        return ResponseHelper::success(true, trans('alert.update_success'));
    }
    /**
     * Method destroy
     *
     * @param ModuleTask $moduleTask [explicite description]
     *
     * @return JsonResponse
     */
    public function destroy(ModuleTask $moduleTask): JsonResponse
    {
        try {
            $this->moduleTask->delete($moduleTask->id);
            return ResponseHelper::success(true, trans('alert.delete_success'));
        } catch (\Throwable $e) {
            return ResponseHelper::success(true, trans('alert.delete_constrained'));
        }
    }

    public function getByCourse(string $slug)
    {
        $moduleTask = $this->moduleTask->getByCourse($slug);
        return ResponseHelper::success(ModuleTaskResource::collection($moduleTask));
    }
}
