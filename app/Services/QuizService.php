<?php

namespace App\Services;

use App\Base\Interfaces\uploads\ShouldHandleFileUpload;
use App\Contracts\Interfaces\BlogInterface;
use App\Contracts\Interfaces\BlogViewInterface;
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
use App\Traits\UploadTrait;
use Illuminate\Http\Request;

class QuizService implements ShouldHandleFileUpload
{

    use UploadTrait;
    private UserQuizInterface $userQuiz;
    public function __construct(UserQuizInterface $userQuiz)
    {
        $this->userQuiz = $userQuiz;
    }
    public function store(Quiz $quiz)
    {
        $data = [];
        $questions = ModuleQuestion::query()->inRandomOrder()->limit($quiz->total_question)->get();
        $moduleIds = $questions->pluck('id')->toArray();
        $data['module_question_id'] = implode(',', $moduleIds);
        $data['user_id'] = auth()->user()->id;
        $data['quiz_id'] = $quiz->id;
        $this->userQuiz->store($data);
    }
}
