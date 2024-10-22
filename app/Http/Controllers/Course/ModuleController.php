<?php

namespace App\Http\Controllers\Course;

use App\Contracts\Interfaces\Course\CourseInterface;
use App\Contracts\Interfaces\Course\ModuleInterface;
use App\Contracts\Interfaces\Course\SubModuleInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ModuleRequest;
use App\Http\Resources\Course\ModuleResource;
use App\Models\Course;
use App\Models\Module;
use App\Services\Course\ModuleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    private ModuleInterface $module;
    private ModuleService $service;
    private CourseInterface $course;
    private SubModuleInterface $subModule;
    /**
     * Method __construct
     *
     * @param ModuleInterface $module [explicite description]
     *
     * @return void
     */
    public function __construct(ModuleInterface $module, SubModuleInterface $subModule, CourseInterface $course, ModuleService $service)
    {
        $this->module = $module;
        $this->service = $service;
        $this->course = $course;
        $this->subModule = $subModule;
    }
    /**
     * Method index
     *
     * @return JsonResponse
     */
    public function index(string $slug, Request $request): JsonResponse
    {
        $course = $this->course->showWithSlug($slug);
        $request->merge(['course_id' => $course->id]);
        $modules = $this->module->search($request);
        return ResponseHelper::success(ModuleResource::collection($modules), trans('alert.fetch_success'));
    }
    /**
     * Method store
     *
     * @param ModuleRequest $request [explicite description]
     *
     * @return JsonResponse
     */
    public function store(string $slug, ModuleRequest $request): JsonResponse
    {
        $course = $this->course->showWithSlug($slug);
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
            $this->service->delete($module);
            return ResponseHelper::success(true, trans('alert.delete_success'));
        } catch (\Throwable $e) {
            return ResponseHelper::error(false, trans('alert.delete_constrained'));
        }
    }

    /**
     * forward
     *
     * @param  mixed $module
     * @return JsonResponse
     */
    public function forward(Module $module): JsonResponse
    {
        try {
            $forwardModule = $this->module->getForward($module->step, $module->course->id);
            $forwardModule->decrement('step');
            $module->increment('step');
            return ResponseHelper::success([$module, $forwardModule], trans('alert.update_success'));
        } catch (\Throwable $e) {
            return ResponseHelper::error(false, trans('alert.update_failed'));
        }
    }

    /**
     * backward
     *
     * @param  mixed $module
     * @return JsonResponse
     */
    public function backward(Module $module): JsonResponse
    {
        try {
            $backwardModule = $this->module->getBackward($module->step, $module->course->id);
            $backwardModule->increment('step');
            $module->decrement('step');
            return ResponseHelper::success([$module, $backwardModule], trans('alert.update_success'));
        } catch (\Throwable $e) {
            return ResponseHelper::error(trans('alert.update_failed'));
        }
    }

    /**
     * listModule
     *
     * @param  mixed $slug
     * @return void
     */
    public function userlistModuleWithSubModul(string $slug, Request $request)
    {
        $subModule = $this->subModule->showWithSlug($slug);
        $request->merge(['course_id' => $subModule->module->course_id]);
        $modules = $this->module->search($request);
        return ResponseHelper::success(ModuleResource::collection($modules));
    }

    /**
     * listModule
     *
     * @return JsonResponse
     */
    public function listModule(string $slug, Request $request): JsonResponse
    {
        $module = $this->module->showWithSlug($slug);
        $request->merge(['course_id' => $module->course_id]);
        $modules = $this->module->search($request);
        return ResponseHelper::success(ModuleResource::collection($modules));
    }
}
