<?php

namespace App\Services;

use App\Base\Interfaces\uploads\ShouldHandleFileUpload;
use App\Contracts\Interfaces\BlogInterface;
use App\Contracts\Interfaces\BlogViewInterface;
use App\Contracts\Interfaces\Course\QuizInterface;
use App\Contracts\Interfaces\Course\UserCourseInterface;
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
use App\Models\Course;
use App\Models\Event;
use App\Models\EventDetail;
use App\Models\ModuleQuestion;
use App\Models\Quiz;
use App\Models\SubModule;
use App\Models\User;
use App\Models\UserQuiz;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use Spatie\ErrorSolutions\SolutionProviders\Laravel\MissingAppKeySolutionProvider;

class UserCourseService
{
    private UserCourseInterface $userCourse;
    public function __construct(UserCourseInterface $userCourse)
    {
        $this->userCourse = $userCourse;
    }
    /**
     * userLastStep
     *
     * @param  mixed $course
     * @param  mixed $subModule
     * @return void
     */
    public function userLastStep(Course $course, SubModule $subModule)
    {
        $userCourse = $this->userCourse->showByUserCourse($course->id);
        $currentStep = $userCourse->subModule->step;
        $currentStepModule = $userCourse->subModule->module->step;

        if ($currentStepModule < $subModule->module->step || $subModule->step > $currentStep) {
            $this->userCourse->update($course->id, ['sub_module_id' => $subModule->id]);
        }
    }
}
