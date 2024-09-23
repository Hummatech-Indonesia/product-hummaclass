<?php

namespace App\Http\Controllers\Course;

use App\Contracts\Interfaces\Course\QuizInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\QuizRequest;
use App\Http\Resources\QuizResource;
use App\Models\Module;
use App\Models\Quiz;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    private QuizInterface $quiz;
    public function __construct(QuizInterface $quiz)
    {
        $this->quiz = $quiz;
    }
    /**
     * Method index
     *
     * @return JsonResponse
     */
    public function index(Module $module): JsonResponse
    {
        $quizzes = $this->quiz->show($module->id);
        return ResponseHelper::success(QuizResource::make($quizzes), trans('alert.fetch_success'));
    }
    /**
     * Method store
     *
     * @param QuizRequest $request [explicite description]
     * @param Module $module [explicite description]
     *
     * @return JsonResponse
     */
    public function store(QuizRequest $request, Module $module): JsonResponse
    {
        $data = $request->validated();
        $data['module_id'] = $module->id;
        $this->quiz->store($data);
        return ResponseHelper::success(true, trans('alert.add_success'));
    }
}
