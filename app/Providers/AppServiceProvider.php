<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\Interfaces\EventInterface;
use App\Contracts\Interfaces\RegisterInterface;
use App\Contracts\Repositories\EventRepository;
use App\Contracts\Interfaces\Auth\UserInterface;
use App\Contracts\Interfaces\Course\QuizInterface;
use App\Contracts\Interfaces\EventDetailInterface;
use App\Contracts\Interfaces\TransactionInterface;
use App\Contracts\Repositories\RegisterRepository;
use App\Contracts\Interfaces\Auth\ProfileInterface;
use App\Contracts\Interfaces\BlogInterface;
use App\Contracts\Interfaces\BlogViewInterface;
use App\Contracts\Repositories\Auth\UserRepository;
use App\Contracts\Interfaces\Course\CourseInterface;
use App\Contracts\Interfaces\Course\ModuleInterface;
use App\Contracts\Repositories\Course\QuizRepository;
use App\Contracts\Repositories\EventDetailRepository;
use App\Contracts\Repositories\TransactionRepository;
use App\Contracts\Interfaces\Course\CategoryInterface;
use App\Contracts\Repositories\Auth\ProfileRepository;
use App\Contracts\Interfaces\Course\SubModuleInterface;
use App\Contracts\Repositories\Course\CourseRepository;
use App\Contracts\Repositories\Course\ModuleRepository;
use App\Contracts\Interfaces\Course\CourseTaskInterface;
use App\Contracts\Interfaces\Course\ModuleTaskInterface;
use App\Contracts\Interfaces\Course\UserCourseInterface;
use App\Contracts\Interfaces\Course\SubCategoryInterface;
use App\Contracts\Repositories\Course\CategoryRepository;
use App\Contracts\Interfaces\Course\CourseReviewInterface;
use App\Contracts\Repositories\Course\SubModuleRepository;
use App\Contracts\Interfaces\Course\CourseVoucherInterface;
use App\Contracts\Repositories\Course\CourseTaskRepository;
use App\Contracts\Repositories\Course\ModuleTaskRepository;
use App\Contracts\Repositories\Course\UserCourseRepository;
use App\Contracts\Interfaces\Configuration\ContactInterface;
use App\Contracts\Interfaces\Course\ModuleQuestionInterface;
use App\Contracts\Interfaces\Course\SubmissionTaskInterface;
use App\Contracts\Repositories\BlogRepository;
use App\Contracts\Repositories\BlogViewRepository;
use App\Contracts\Repositories\Course\SubCategoryRepository;
use App\Contracts\Repositories\Course\CourseReviewRepository;
use App\Contracts\Repositories\Course\CourseVoucherRepository;
use App\Contracts\Repositories\Configuration\ContactRepository;
use App\Contracts\Repositories\Course\ModuleQuestionRepository;
use App\Contracts\Repositories\Course\SubmissionTaskRepository;

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
    }
}
