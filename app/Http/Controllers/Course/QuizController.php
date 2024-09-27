<?php

namespace App\Http\Controllers\Course;

use App\Contracts\Interfaces\Course\QuizInterface;
use App\Contracts\Interfaces\UserQuizInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\QuizRequest;
use App\Http\Resources\QuizResource;
use App\Http\Resources\UserQuizResource;
use App\Models\Module;
use App\Models\Quiz;
use App\Services\QuizService;
use App\Traits\PaginationTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    use PaginationTrait;
    private QuizInterface $quiz;
    private UserQuizInterface $userQuiz;

    private QuizService $service;
    public function __construct(QuizInterface $quiz, QuizService $service, UserQuizInterface $userQuiz)
    {
        $this->quiz = $quiz;
        $this->userQuiz = $userQuiz;
        $this->service = $service;
    }
    /**
     * Method index
     *
     * @return JsonResponse
     */
    public function index(Module $module): JsonResponse
    {
        $quiz = $this->quiz->show($module->id);
        return ResponseHelper::success(QuizResource::make($quiz), trans('alert.fetch_success'));
    }
    public function show(Request $request, Quiz $quiz): JsonResponse
    {
        $this->service->store($quiz);
        $request->merge(['quiz_id' => $quiz->id]);
        $userQuizzes = $this->userQuiz->customPaginate($request);
        // dd($userQuizzes);   
        $data['paginate'] = $this->customPaginate($userQuizzes->currentPage(), $userQuizzes->lastPage());
        $data['data'] = UserQuizResource::collection($userQuizzes);
        return responsehelper::success($data, trans('alert.fetch_success'));
    }
    public function get(): JsonResponse
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
}
