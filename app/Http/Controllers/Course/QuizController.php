<?php

namespace App\Http\Controllers\Course;

use App\Contracts\Interfaces\Course\ModuleInterface;
use App\Contracts\Interfaces\Course\ModuleQuestionInterface;
use App\Contracts\Interfaces\Course\QuizInterface;
use App\Contracts\Interfaces\UserQuizInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\QuizRequest;
use App\Http\Requests\UserQuizRequest;
use App\Http\Resources\ModuleQuestionResource;
use App\Http\Resources\QuizResource;
use App\Http\Resources\ResultResource;
use App\Http\Resources\UserQuizResource;
use App\Models\Module;
use App\Models\ModuleQuestion;
use App\Models\Quiz;
use App\Models\UserQuiz;
use App\Services\QuizService;
use App\Traits\PaginationTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    use PaginationTrait;
    private QuizInterface $quiz;
    private ModuleInterface $module;
    private UserQuizInterface $userQuiz;
    private ModuleQuestionInterface $moduleQuestion;

    private QuizService $service;
    public function __construct(QuizInterface $quiz, ModuleQuestionInterface $moduleQuestion, QuizService $service, UserQuizInterface $userQuiz, ModuleInterface $module)
    {
        $this->quiz = $quiz;
        $this->module = $module;
        $this->userQuiz = $userQuiz;
        $this->moduleQuestion = $moduleQuestion;
        $this->service = $service;
    }
    /**
     * Method index
     *
     * @return JsonResponse
     */
    public function slug(string $slug): JsonResponse
    {
        $module = $this->module->showWithSlug($slug);
        $quiz = $module->quizzes->first();
        return ResponseHelper::success(QuizResource::make($quiz), trans('alert.fetch_success'));
    }
    /**
     * index
     *
     * @param  mixed $slug
     * @return JsonResponse
     */
    public function index(string $slug): JsonResponse
    {
        $module = $this->module->showWithSlug($slug);
        if ($module->quizzes->first()) {
            $quiz = $module->quizzes->first();
            return ResponseHelper::success(QuizResource::make($quiz), trans('alert.fetch_success'));
        } else {
            return ResponseHelper::error(null, 'Quiz belum ada');
        }
    }

    public function show(Request $request, Quiz $quiz): JsonResponse
    {
        $moduleIds = $this->service->store($quiz);

        $request->merge(['id' => $moduleIds['questions']->pluck('id')]);

        $moduleQuestions = $this->moduleQuestion->customPaginate($request);
        $data['paginate'] = $this->customPaginate($moduleQuestions->currentPage(), $moduleQuestions->lastPage());
        $data['data'] = ModuleQuestionResource::collection($moduleQuestions);
        $data['user_quiz'] = UserQuizResource::make($moduleIds['userQuiz']);

        return responsehelper::success($data, trans('alert.fetch_success'));
    }
    public function submit(UserQuizRequest $request, UserQuiz $userQuiz): JsonResponse
    {
        $this->service->submit($request, $userQuiz);
        return ResponseHelper::success($userQuiz->score, trans('alert.fetch_success'));
    }

    /**
     * Method result
     *
     * @return JsonResponse
     */
    public function result(): JsonResponse
    {
        $result = $this->userQuiz->getLatestResult();
        return ResponseHelper::success(ResultResource::make($result), trans('alert.fetch_success'));
    }
    /**
     * get
     *
     * @return JsonResponse
     */
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
