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
    public function index(): JsonResponse
    {
        $quizzes = $this->quiz->get();
        return ResponseHelper::success(QuizResource::collection($quizzes), trans('alert.fetch_success'));
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
    /**
     * Method update
     *
     * @param QuizRequest $request [explicite description]
     * @param Quiz $quiz [explicite description]
     *
     * @return JsonResponse
     */
    public function update(QuizRequest $request, Quiz $quiz): JsonResponse
    {
        $this->quiz->update($quiz->id, $request->validated());
        return ResponseHelper::success(true, trans('alert.update_success'));
    }
    /**
     * Method destroy
     *
     * @param Quiz $quiz [explicite description]
     *
     * @return JsonResponse
     */
    public function destroy(Quiz $quiz): JsonResponse
    {
        $this->quiz->delete($quiz->id);
        return ResponseHelper::success(true, trans('alert.delete_success'));
    }
}
