<?php

namespace App\Http\Controllers\Course;

use App\Contracts\Interfaces\Course\ModuleInterface;
use App\Contracts\Interfaces\UserQuizInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserQuizRequest;
use App\Http\Resources\UserQuizResource;
use App\Http\Resources\UserQuizResultResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserQuizController extends Controller
{
    private UserQuizInterface $userQuiz;
    private ModuleInterface $module;
    public function __construct(UserQuizInterface $userQuiz, ModuleInterface $module)
    {
        $this->userQuiz = $userQuiz;
        $this->module = $module;
    }
    /**
     * Method index
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $userQuizzes = $this->userQuiz->get();
        return ResponseHelper::success(UserQuizResource::collection($userQuizzes), trans('alert.fetch_success'));
    }
    public function getByUser(string $slug): JsonResponse
    {
        $moduleId = $this->module->showWithSlug($slug);
        $userQuizzes = $this->userQuiz->getWhere(['module_id' => $moduleId]);
        return ResponseHelper::success(UserQuizResultResource::collection($userQuizzes), trans('alert.fetch_success'));
    }
    /**
     * Method store
     *
     * @param UserQuizRequest $request [explicite description]
     *
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $this->userQuiz->store($request->validated());
        return ResponseHelper::success(true, trans('alert.add_success'));
    }
}
