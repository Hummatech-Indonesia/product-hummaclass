<?php

namespace App\Providers;

use App\Models\AssessmentForm;
use App\Models\Attendance;
use App\Models\AttendanceStudent;
use App\Models\Blog;
use App\Models\Challenge;
use App\Models\ChallengeSubmit;
use App\Models\Classroom;
use App\Models\Course;
use App\Models\CourseLearningPath;
use App\Models\CourseTask;
use App\Models\CourseTest;
use App\Models\CourseVoucher;
use App\Models\Division;
use App\Models\Event as ModelsEvent;
use App\Models\Journal;
use App\Models\LearningPath;
use App\Models\Modul;
use App\Models\Module;
use App\Models\ModuleQuestion;
use App\Models\ModuleTask;
use App\Models\Quiz;
use App\Models\Reward;
use App\Models\School;
use App\Models\Student;
use App\Models\StudentClassroom;
use App\Models\SubmissionTask;
use App\Models\SubModule;
use App\Models\Teacher;
use App\Models\User;
use App\Models\UserCourseTest;
use App\Models\UserQuiz;
use App\Observers\AssesmentFormObserver;
use App\Observers\AttendanceObserver;
use App\Observers\AttendanceStudentObserver;
use App\Observers\BlogObserver;
use App\Observers\ChallengeObserver;
use App\Observers\ChallengeSubmitObserver;
use App\Observers\ClassroomObserver;
use App\Observers\CourseLearningPathObserver;
use App\Observers\CourseObserver;
use App\Observers\CourseTaskObserver;
use App\Observers\CourseTestObserver;
use App\Observers\CourseVoucherObserver;
use App\Observers\DivisionObserver;
use App\Observers\EventObserver;
use App\Observers\JournalObserver;
use App\Observers\LearningPathObserver;
use App\Observers\ModuleObserver;
use App\Observers\ModuleQuestionObserver;
use App\Observers\ModuleTaskObserver;
use App\Observers\ModulObserver;
use App\Observers\QuizObserver;
use App\Observers\RewardObserver;
use App\Observers\SchoolObserver;
use App\Observers\StudentClassroomObserver;
use App\Observers\StudentObserver;
use App\Observers\SubmissionTaskObserver;
use App\Observers\SubModuleObserver;
use App\Observers\TeacherObserver;
use App\Observers\UserCourseTestObserver;
use App\Observers\UserObserver;
use App\Observers\UserQuizObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        User::observe(UserObserver::class);
        Course::observe(CourseObserver::class);
        Module::observe(ModuleObserver::class);
        SubModule::observe(SubModuleObserver::class);
        ModuleQuestion::observe(ModuleQuestionObserver::class);
        Quiz::observe(QuizObserver::class);
        ModuleTask::observe(ModuleTaskObserver::class);
        SubmissionTask::observe(SubmissionTaskObserver::class);
        CourseVoucher::observe(CourseVoucherObserver::class);
        ModelsEvent::observe(EventObserver::class);
        Blog::observe(BlogObserver::class);
        UserQuiz::observe(UserQuizObserver::class);
        CourseTest::observe(CourseTestObserver::class);
        UserCourseTest::observe(UserCourseTestObserver::class);
        Reward::observe(RewardObserver::class);
        School::observe(SchoolObserver::class);
        LearningPath::observe(LearningPathObserver::class);
        Classroom::observe(ClassroomObserver::class);
        Teacher::observe(TeacherObserver::class);
        Student::observe(StudentObserver::class);
        StudentClassroom::observe(StudentClassroomObserver::class);
        Division::observe(DivisionObserver::class);
        Challenge::observe(ChallengeObserver::class);
        ChallengeSubmit::observe(ChallengeSubmitObserver::class);
        Attendance::observe(AttendanceObserver::class);
        AttendanceStudent::observe(AttendanceStudentObserver::class);
        CourseLearningPath::observe(CourseLearningPathObserver::class);
        Journal::observe(JournalObserver::class);
        AssessmentForm::observe(AssesmentFormObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
