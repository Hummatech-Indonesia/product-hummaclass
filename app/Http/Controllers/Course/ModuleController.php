<?php

namespace App\Http\Controllers\Course;

use App\Contracts\Interfaces\Course\ModuleInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ModuleRequest;
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
    public function index(): JsonResponse
    {
        $data = $this->module->get();
        return ResponseHelper::success($data, trans('alert.fetch_success'));
    }    
    /**
     * Method store
     *
     * @param ModuleRequest $request [explicite description]
     *
     * @return JsonResponse
     */
    public function store(ModuleRequest $request): JsonResponse
    {
        $this->module->store($request->validated());
        return ResponseHelper::success(true, trans('alert.add_success'));
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
}
