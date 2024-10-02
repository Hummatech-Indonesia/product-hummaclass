<?php

namespace App\Services;

use App\Base\Interfaces\uploads\ShouldHandleFileUpload;
use App\Contracts\Interfaces\BlogInterface;
use App\Contracts\Interfaces\BlogViewInterface;
use App\Contracts\Interfaces\EventDetailInterface;
use App\Contracts\Interfaces\EventInterface;
use App\Contracts\Interfaces\UserCourseTestInterface;
use App\Contracts\Interfaces\UserQuizInterface;
use App\Enums\UploadDiskEnum;
use App\Http\Requests\BlogRequest;
use App\Http\Requests\CourseRequest;
use App\Http\Requests\EventRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\UserQuizRequest;
use App\Models\Blog;
use App\Models\CourseTest;
use App\Models\Event;
use App\Models\EventDetail;
use App\Models\ModuleQuestion;
use App\Models\Quiz;
use App\Models\User;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;

class CourseTestService implements ShouldHandleFileUpload
{

    use UploadTrait;
    private UserCourseTestInterface $userCourseTest;
    public function __construct(UserCourseTestInterface $userCourseTest)
    {
        $this->userCourseTest = $userCourseTest;
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
}
