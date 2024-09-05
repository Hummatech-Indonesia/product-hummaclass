<?php

namespace App\Http\Controllers\Course;

use App\Contracts\Interfaces\Course\SubModuleInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubModuleRequest;
use App\Http\Resources\SubModuleResource;
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
     * Method index
     *
     * @param Request $request [explicite description]
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $subModules = $this->subModule->customPaginate($request);
        return ResponseHelper::success(SubModuleResource::collection($subModules), trans('alert.fetch_success'));
    }
    /**
     * Method store
     *
     * @param SubModuleRequest $request [explicite description]
     *
     * @return JsonResponse
     */
    public function store(SubModuleRequest $request): JsonResponse
    {
        $this->subModule->store($request->validated());
        return ResponseHelper::success(true, trans('alert.add_success'));
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
