<?php

namespace App\Http\Controllers\Course;

use App\Contracts\Interfaces\Course\SubModuleInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubModuleRequest;
use App\Http\Resources\SubModuleResource;
use App\Models\Module;
use App\Models\SubModule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubModuleController extends Controller
{
    private SubModuleInterface $subModule;
    public function __construct(SubModuleInterface $subModule)
    {
        $this->subModule = $subModule;
    }
    /**
     * Method store
     *
     * @param SubModuleRequest $request [explicite description]
     *
     * @return JsonResponse
     */
    public function store(SubModuleRequest $request, Module $module): JsonResponse
    {
        $data = $request->validated();
        $data['module_id'] = $module->id;
        $subModule = $this->subModule->getOneByModul($module->id);
        if ($subModule != null) {
            $data['step'] = $subModule->step + 1;
        } else {
            $data['step'] = 1;
        }
        $subModule = $this->subModule->store($data);
        return ResponseHelper::success(SubModuleResource::make($subModule), trans('alert.add_success'));
    }
    /**
     * Method update
     *
     * @param SubModuleRequest $request [explicite description]
     * @param SubModule $subModule [explicite description]
     *
     * @return JsonResponse
     */
    public function update(SubModuleRequest $request, SubModule $subModule): JsonResponse
    {
        $this->subModule->update($subModule->id, $request->validated());
        return ResponseHelper::success(true, trans('alert.update_success'));
    }
    /**
     * Method destroy
     *
     * @param SubModule $subModule [explicite description]
     *
     * @return JsonResponse
     */
    public function destroy(SubModule $subModule): JsonResponse
    {
        try {
            $this->subModule->delete($subModule->id);
            return ResponseHelper::success(true, trans('alert.delete_success'));
        } catch (\Throwable $e) {
            return ResponseHelper::error(false, trans('alert.delete_constrained'));
        }
    }
}
