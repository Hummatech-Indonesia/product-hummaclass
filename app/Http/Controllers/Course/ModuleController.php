<?php

namespace App\Http\Controllers\Course;

use App\Contracts\Interfaces\Course\ModuleInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ModuleRequest;
use App\Http\Resources\Course\ModuleResource;
use App\Models\Course;
use App\Models\Module;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    private ModuleInterface $module;
    /**
     * Method __construct
     *
     * @param ModuleInterface $module [explicite description]
     *
     * @return void
     */
    public function __construct(ModuleInterface $module)
    {
        $this->module = $module;
    }
    /**
     * Method index
     *
     * @return JsonResponse
     */
    public function index(Course $course, Request $request): JsonResponse
    {
        $request->merge(['course_id' => $course->id]);
        $modules = $this->module->customPaginate($request);
        return ResponseHelper::success(ModuleResource::collection($modules), trans('alert.fetch_success'));
    }
    /**
     * Method store
     *
     * @param ModuleRequest $request [explicite description]
     *
     * @return JsonResponse
     */
    public function store(Course $course, ModuleRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['course_id'] = $course->id;

        $module = $this->module->getOneByCourse($course->id);
        if ($module != null) {
            $data['step'] = $module->step + 1;
        } else {
            $data['step'] = 1;
        }
        $this->module->store($data);
        return ResponseHelper::success(true, trans('alert.add_success'));
    }

    /**
     * Method show
     *
     * @param Module $module [explicite description]
     *
     * @return JsonResponse
     */
    public function show(Module $module): JsonResponse
    {
        $module = $this->module->show($module->id);
        return ResponseHelper::success(new ModuleResource($module));
    }

    /**
     * Method update
     *
     * @param ModuleRequest $request [explicite description]
     * @param Module $module [explicite description]
     *
     * @return JsonResponse
     */
    public function update(ModuleRequest $request, Module $module): JsonResponse
    {
        $this->module->update($module->id, $request->validated());
        return ResponseHelper::success(true, trans('alert.update_success'));
    }
    /**
     * Method destroy
     *
     * @param Module $module [explicite description]
     *
     * @return JsonResponse
     */
    public function destroy(Module $module): JsonResponse
    {
        try {
            $this->module->delete($module->id);
            return ResponseHelper::success(true, trans('alert.delete_success'));
        } catch (\Throwable $e) {
            return ResponseHelper::error(false, trans('alert.delete_constrained'));
        }
    }
    public function forward(Module $module): JsonResponse
    {
        try {
            $forwardModule = $this->module->getForward($module->step);
            $forwardModule->decrement('step');
            $module->increment('step');
            return ResponseHelper::success([$module, $forwardModule], trans('alert.update_success'));
        } catch (\Throwable $e) {
            return ResponseHelper::error(false, trans('alert.update_failed'));
        }
    }

    public function backward(Module $module): JsonResponse
    {
        try {
            $forwardModule = $this->module->getBackward($module->step);
            $forwardModule->increment('step');
            $module->decrement('step');
            return ResponseHelper::success([$module, $forwardModule], trans('alert.update_success'));
        } catch (\Throwable $e) {
            return ResponseHelper::error(trans('alert.update_failed'));
        }
    }
}
