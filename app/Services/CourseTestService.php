<?php

namespace App\Services;

use App\Base\Interfaces\uploads\ShouldHandleFileUpload;
use App\Contracts\Interfaces\BlogInterface;
use App\Contracts\Interfaces\BlogViewInterface;
use App\Contracts\Interfaces\Course\ModuleQuestionInterface;
use App\Contracts\Interfaces\EventDetailInterface;
use App\Contracts\Interfaces\EventInterface;
use App\Contracts\Interfaces\UserCourseTestInterface;
use App\Contracts\Interfaces\UserQuizInterface;
use App\Enums\UploadDiskEnum;
use App\Http\Requests\BlogRequest;
use App\Http\Requests\CourseRequest;
use App\Http\Requests\EventRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\UserCourseTestRequest;
use App\Http\Requests\UserQuizRequest;
use App\Models\Blog;
use App\Models\CourseTest;
use App\Models\Event;
use App\Models\EventDetail;
use App\Models\ModuleQuestion;
use App\Models\Quiz;
use App\Models\User;
use App\Models\UserCourseTest;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;

class CourseTestService implements ShouldHandleFileUpload
{

    use UploadTrait;
    private UserCourseTestInterface $userCourseTest;
    private ModuleQuestionInterface $module;
    public function __construct(UserCourseTestInterface $userCourseTest, ModuleQuestionInterface $module)
    {
        $this->userCourseTest = $userCourseTest;
        $this->module = $module;
    }
    public function store(CourseTest $courseTest)
    {
        $data = [];
        $questions = ModuleQuestion::query()->inRandomOrder()->limit($courseTest->total_question)->get();
        $moduleIds = $questions->pluck('id')->toArray();
        $data['module_question_id'] = implode(',', $moduleIds);
        $data['user_id'] = auth()->user()->id;
        $data['course_id'] = $courseTest->id;
        $this->userCourseTest->store($data);
    }
    public function preTest(CourseTest $courseTest)
    {
        try {
            $preTest = $courseTest
                ->userCourseTests()
                ->where('user_id', auth()->user()->id)
                ->whereNull('pre_test_score')
                ->latest()
                ->first();
            return [
                'preTest' => $preTest,
                'questions' => explode(',', $preTest->module_question_id)
            ];
        } catch (\Throwable $e) {
            $questions = $this->module->getQuestions($courseTest->course_id, $courseTest->total_question);
            $module_question_id = implode(',', $questions->pluck('id')->toArray());
            $data = [];
            $data['module_question_id'] = $module_question_id;
            $data['user_id'] = auth()->user()->id;
            $data['course_test_id'] = $courseTest->id;
            $preTest = $this->userCourseTest->store($data);
            return [
                'preTest' => $preTest,
                'questions' => explode(',', $preTest->module_question_id)
            ];
        }
    }
    public function postTest(CourseTest $courseTest)
    {
        $postTest = $courseTest
            ->userCourseTests()
            ->where('user_id', auth()->user()->id)
            ->whereNotNull('pre_test_score')
            ->latest()
            ->first();
        $postTest->post_test_score;
        return [
            'postTest' => $postTest,
            'questions' => explode(',', $postTest->module_question_id)
        ];
    }
    public function submit(UserCourseTestRequest $request, UserCourseTest $userCourseTest)
    {
        $data = $request->validated();
        $answers = array_map(function ($answer) {
            return $answer ?? 'null';
        }, $data['answer']);
        $questionIds = explode(',', $userCourseTest->module_question_id);
        $moduleQuestions = ModuleQuestion::query()
            ->whereIn('id', $questionIds)
            ->orderByRaw("FIELD(id, '" . implode("', '", $questionIds) . "')")
            ->get('answer');
        $questionAnswers = $moduleQuestions->pluck('answer')->toArray();
        $score = 0;

        foreach ($answers as $index => $userAnswer) {
            if (isset($questionAnswers[$index]) && $userAnswer == $questionAnswers[$index]) {
                $score++;
            }
        }
        $score = count(value: $moduleQuestions) > 0 ? ($score / count($moduleQuestions)) * 100 : 0;
        if ($userCourseTest->pre_test_score) {
            $userCourseTestData = [
                'post_test_score' => $score,
                'answer' => implode(',', $answers),
            ];
        } else {
            $userCourseTestData = [
                'pre_test_score' => $score,
                'answer' => implode(',', $answers),
            ];
        }
        $this->userCourseTest->update($userCourseTest->id, $userCourseTestData);

    }
}
