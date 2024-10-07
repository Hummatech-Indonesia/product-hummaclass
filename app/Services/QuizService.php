<?php

namespace App\Services;

use App\Base\Interfaces\uploads\ShouldHandleFileUpload;
use App\Contracts\Interfaces\BlogInterface;
use App\Contracts\Interfaces\BlogViewInterface;
use App\Contracts\Interfaces\Course\QuizInterface;
use App\Contracts\Interfaces\EventDetailInterface;
use App\Contracts\Interfaces\EventInterface;
use App\Contracts\Interfaces\UserQuizInterface;
use App\Enums\UploadDiskEnum;
use App\Http\Requests\BlogRequest;
use App\Http\Requests\CourseRequest;
use App\Http\Requests\EventRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\UserQuizRequest;
use App\Models\Blog;
use App\Models\Event;
use App\Models\EventDetail;
use App\Models\ModuleQuestion;
use App\Models\Quiz;
use App\Models\User;
use App\Models\UserQuiz;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use Spatie\ErrorSolutions\SolutionProviders\Laravel\MissingAppKeySolutionProvider;

class QuizService implements ShouldHandleFileUpload
{

    use UploadTrait;
    private UserQuizInterface $userQuiz;
    private QuizInterface $quiz;
    public function __construct(UserQuizInterface $userQuiz, QuizInterface $quiz)
    {
        $this->quiz = $quiz;
        $this->userQuiz = $userQuiz;
    }
    public function store(Quiz $quiz)
    {
        $userQuiz = $quiz->userQuizzes->where('user_id', auth()->user()->id)->first();

        if ($userQuiz) {
            $moduleIds = explode(',', $quiz->module_question_id);
            // $questions = ModuleQuestion::query()->whereIn('id', $moduleIds)->get();
            $questions = ModuleQuestion::query()->inRandomOrder()->limit($quiz->total_question)->get();
        } else {
            $questions = ModuleQuestion::query()->inRandomOrder()->limit($quiz->total_question)->get();
            $moduleIds = $questions->pluck('id')->toArray();
            $module_question_id = implode(',', $moduleIds);

            $userQuizData = [
                'module_question_id' => $module_question_id,
                'quiz_id' => $quiz->id,
                'user_id' => auth()->user()->id
            ];
            $this->userQuiz->store($userQuizData);
        }

        return [
            'questions' => $questions,
            'userQuiz' => $userQuiz
        ];
    }

    public function submit(UserQuizRequest $request, UserQuiz $userQuiz): void
    {
        $data = $request->validated();
        $answers = array_map(function ($answer) {
            return $answer == "" ? 'null' : $answer;
        }, $data['answer']);
        $questions = explode(',', $userQuiz->module_question_id);

        $correctCount = 0;

        foreach ($questions as $index => $questionId) {
            $moduleQuestion = ModuleQuestion::find($questionId);
            if (isset($answers[$index]) && $answers[$index] == $moduleQuestion->answer) {
                $correctCount++;
            }
        }



        $quiz = $userQuiz->quiz;
        $score = count(value: $questions) > 0 ? ($correctCount / count($questions)) * 100 : 0;
        $stringAnswer = implode(',', $answers);
        $userQuizData = [
            'score' => $score,
            'answer' => $stringAnswer,
            'has_submitted' => true,
        ];
        $quizData = [
            'is_submitted' => true,
            'retry_delay' => 60,
            'minimum_score' => 60,
        ];
        $this->userQuiz->update($userQuiz->id, $userQuizData);
        $this->quiz->update($quiz->id, $quizData);
    }
}
