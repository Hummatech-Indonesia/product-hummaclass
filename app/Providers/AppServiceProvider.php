<?php

namespace App\Providers;

use App\Contracts\Interfaces\EventAttendanceInterface;
use App\Contracts\Interfaces\UserEventAttendanceInterface;
use App\Contracts\Repositories\UserEventAttendanceRepository;
use Illuminate\Support\ServiceProvider;
use App\Contracts\Interfaces\BlogInterface;
use App\Contracts\Interfaces\EventInterface;
use App\Contracts\Repositories\BlogRepository;
use App\Contracts\Interfaces\BlogViewInterface;
use App\Contracts\Interfaces\RegisterInterface;
use App\Contracts\Interfaces\UserQuizInterface;
use App\Contracts\Repositories\EventRepository;
use App\Contracts\Interfaces\Auth\UserInterface;
use App\Contracts\Interfaces\Course\QuizInterface;
use App\Contracts\Interfaces\EventDetailInterface;
use App\Contracts\Interfaces\TransactionInterface;
use App\Contracts\Repositories\BlogViewRepository;
use App\Contracts\Repositories\RegisterRepository;
use App\Contracts\Repositories\UserQuizRepository;
use App\Contracts\Interfaces\Auth\ProfileInterface;
use App\Contracts\Interfaces\CertificateInterface;
use App\Contracts\Interfaces\ChallengeInterface;
use App\Contracts\Repositories\Auth\UserRepository;
use App\Contracts\Repositories\UserEventRepository;
use App\Contracts\Interfaces\Course\CourseInterface;
use App\Contracts\Interfaces\Course\ModuleInterface;
use App\Contracts\Interfaces\UserCourseTestInterface;
use App\Contracts\Repositories\Course\QuizRepository;
use App\Contracts\Repositories\EventDetailRepository;
use App\Contracts\Repositories\TransactionRepository;
use App\Contracts\Interfaces\Course\CategoryInterface;
use App\Contracts\Repositories\Auth\ProfileRepository;
use App\Contracts\Interfaces\Course\SubModuleInterface;
use App\Contracts\Interfaces\Course\UserEventInterface;
use App\Contracts\Repositories\Course\CourseRepository;
use App\Contracts\Repositories\Course\ModuleRepository;
use App\Contracts\Interfaces\Course\CourseTaskInterface;
use App\Contracts\Interfaces\Course\CourseTestInterface;
use App\Contracts\Interfaces\Course\ModuleTaskInterface;
use App\Contracts\Interfaces\Course\UserCourseInterface;
use App\Contracts\Repositories\UserCourseTestRepository;
use App\Contracts\Interfaces\Course\SubCategoryInterface;
use App\Contracts\Repositories\Course\CategoryRepository;
use App\Contracts\Interfaces\Course\CourseReviewInterface;
use App\Contracts\Repositories\Course\SubModuleRepository;
use App\Contracts\Interfaces\Course\CourseVoucherInterface;
use App\Contracts\Repositories\Course\CourseTaskRepository;
use App\Contracts\Repositories\Course\CourseTestRepository;
use App\Contracts\Repositories\Course\ModuleTaskRepository;
use App\Contracts\Repositories\Course\UserCourseRepository;
use App\Contracts\Interfaces\Configuration\ContactInterface;
use App\Contracts\Interfaces\Course\CourseTestQuestionInterface;
use App\Contracts\Interfaces\Course\ModuleQuestionInterface;
use App\Contracts\Interfaces\Course\SubmissionTaskInterface;
use App\Contracts\Interfaces\DiscussionAnswerInterface;
use App\Contracts\Interfaces\DiscussionInterface;
use App\Contracts\Interfaces\DiscussionTagInterface;
use App\Contracts\Interfaces\FaqInterface;
use App\Contracts\Interfaces\IndustryClass\ClassroomInterface;
use App\Contracts\Interfaces\IndustryClass\DivisionInterface;
use App\Contracts\Interfaces\IndustryClass\SchoolInterface;
use App\Contracts\Interfaces\IndustryClass\SchoolYearInterface;
use App\Contracts\Interfaces\IndustryClass\StudentClassroomInterface;
use App\Contracts\Interfaces\IndustryClass\StudentInterface;
use App\Contracts\Interfaces\IndustryClass\TeacherInterface;
use App\Contracts\Interfaces\RewardInterface;
use App\Contracts\Interfaces\TagInterface;
use App\Contracts\Interfaces\UserRewardInterface;
use App\Contracts\Repositories\CertificateRepository;
use App\Contracts\Repositories\ChallengeRepository;
use App\Contracts\Repositories\Course\SubCategoryRepository;
use App\Contracts\Repositories\Course\CourseReviewRepository;
use App\Contracts\Repositories\Course\CourseVoucherRepository;
use App\Contracts\Repositories\Configuration\ContactRepository;
use App\Contracts\Repositories\Course\CourseTestQuestionRepository;
use App\Contracts\Repositories\Course\ModuleQuestionRepository;
use App\Contracts\Repositories\Course\SubmissionTaskRepository;
use App\Contracts\Repositories\DiscussionAnswerRepository;
use App\Contracts\Repositories\DiscussionRepository;
use App\Contracts\Repositories\DiscussionTagRepository;
use App\Contracts\Repositories\EventAttendanceRepository;
use App\Contracts\Repositories\FaqRepository;
use App\Contracts\Repositories\IndustryClass\ClassroomRepository;
use App\Contracts\Repositories\IndustryClass\DivisionRepository;
use App\Contracts\Repositories\IndustryClass\SchoolRepository;
use App\Contracts\Repositories\IndustryClass\SchoolYearRepository;
use App\Contracts\Repositories\IndustryClass\StudentClassroomRepository;
use App\Contracts\Repositories\IndustryClass\StudentRepository;
use App\Contracts\Repositories\IndustryClass\TeacherRepository;
use App\Contracts\Repositories\RewardRepository;
use App\Contracts\Repositories\TagRepository;
use App\Contracts\Repositories\UserRewardRepository;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{

    private array $register = [
        RegisterInterface::class => RegisterRepository::class,
        CategoryInterface::class => CategoryRepository::class,
        SubCategoryInterface::class => SubCategoryRepository::class,
        CourseInterface::class => CourseRepository::class,
        ProfileInterface::class => ProfileRepository::class,
        CourseReviewInterface::class => CourseReviewRepository::class,
        ModuleInterface::class => ModuleRepository::class,
        SubModuleInterface::class => SubModuleRepository::class,
        UserInterface::class => UserRepository::class,
        ModuleQuestionInterface::class => ModuleQuestionRepository::class,
        QuizInterface::class => QuizRepository::class,
        ModuleTaskInterface::class => ModuleTaskRepository::class,
        SubmissionTaskInterface::class => SubmissionTaskRepository::class,
        UserCourseInterface::class => UserCourseRepository::class,
        CourseVoucherInterface::class => CourseVoucherRepository::class,
        ContactInterface::class => ContactRepository::class,
        EventInterface::class => EventRepository::class,
        EventDetailInterface::class => EventDetailRepository::class,
        TransactionInterface::class => TransactionRepository::class,
        BlogInterface::class => BlogRepository::class,
        BlogViewInterface::class => BlogViewRepository::class,
        UserQuizInterface::class => UserQuizRepository::class,
        CourseTestInterface::class => CourseTestRepository::class,
        UserCourseTestInterface::class => UserCourseTestRepository::class,
        UserEventInterface::class => UserEventRepository::class,
        FaqInterface::class => FaqRepository::class,
        DiscussionTagInterface::class => DiscussionTagRepository::class,
        DiscussionInterface::class => DiscussionRepository::class,
        DiscussionAnswerInterface::class => DiscussionAnswerRepository::class,
        TagInterface::class => TagRepository::class,
        CertificateInterface::class => CertificateRepository::class,
        RewardInterface::class => RewardRepository::class,
        CourseTestQuestionInterface::class => CourseTestQuestionRepository::class,
        UserRewardInterface::class => UserRewardRepository::class,
        EventAttendanceInterface::class => EventAttendanceRepository::class,
        UserEventAttendanceInterface::class => UserEventAttendanceRepository::class,
        SchoolInterface::class => SchoolRepository::class,
        ClassroomInterface::class => ClassroomRepository::class,
        StudentInterface::class => StudentRepository::class,
        StudentClassroomInterface::class => StudentClassroomRepository::class,
        DivisionInterface::class => DivisionRepository::class,
        TeacherInterface::class => TeacherRepository::class,
        SchoolYearInterface::class => SchoolYearRepository::class,
        ChallengeInterface::class => ChallengeRepository::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        foreach ($this->register as $index => $value)
            $this->app->bind($index, $value);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Carbon::setLocale('id');
    }
}
