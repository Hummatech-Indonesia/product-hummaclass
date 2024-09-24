<?php

namespace App\Http\Controllers\Course;

use App\Contracts\Interfaces\Course\ModuleQuestionInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ModuleQuestionRequest;
use App\Http\Resources\ModuleQuestionResource;
use App\Models\Module;
use App\Models\ModuleQuestion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ModuleQuestionController extends Controller
{
    private ModuleQuestionInterface $moduleQuestion;
    public function __construct(ModuleQuestionInterface $moduleQuestion)
    {
        $this->moduleQuestion = $moduleQuestion;
    }
    /**
     * Method index
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $moduleQuestions = $this->moduleQuestion->get();
        return ResponseHelper::success(ModuleQuestionResource::collection($moduleQuestions), trans('alert.fetch_success'));
    }
    /**
     * Method store
     *
     * @param ModuleQuestionRequest $request [explicite description]
     * @param Module $module [explicite description]
     *
     * @return JsonResponse
     */
    public function store(ModuleQuestionRequest $request, Module $module): JsonResponse
    {
        $data = $request->validated();
        $data['module_id'] = $module->id;
        $this->moduleQuestion->store($data);
        return ResponseHelper::success(true, trans('alert.add_success'));
    }

    /**
     * Method update
     *
     * @param ModuleQuestionRequest $request [explicite description]
     * @param ModuleQuestion $moduleQuestion [explicite description]
     *
     * @return JsonResponse
     */
    public function update(ModuleQuestionRequest $request, ModuleQuestion $moduleQuestion): JsonResponse
    {
        $this->moduleQuestion->update($moduleQuestion->id, $request->validated());
        return ResponseHelper::success(true, trans('alert.update_success'));
    }
    /**
     * Method destroy
     *
     * @param ModuleQuestion $moduleQuestion [explicite description]
     *
     * @return JsonResponse
     */
    public function destroy(ModuleQuestion $moduleQuestion): JsonResponse
    {
        $this->moduleQuestion->delete($moduleQuestion->id);
        return ResponseHelper::success(true, trans('alert.delete_success'));
    }
}
