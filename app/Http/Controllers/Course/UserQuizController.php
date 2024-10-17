<?php

namespace App\Http\Controllers\Course;

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
    public function __construct(UserQuizInterface $userQuiz)
    {
        $this->userQuiz = $userQuiz;
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
    public function getByUser(): JsonResponse
    {
        $userQuizzes = $this->userQuiz->getWhere(['user_id' => auth()->user()->id]);
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
