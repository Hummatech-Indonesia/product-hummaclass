<?php

namespace App\Providers;

use App\Contracts\Interfaces\Auth\ProfileInterface;
use App\Contracts\Interfaces\Auth\UserInterface;
use App\Contracts\Interfaces\Course\CategoryInterface;
use App\Contracts\Interfaces\Course\CourseInterface;
use App\Contracts\Interfaces\Course\CourseReviewInterface;
use App\Contracts\Interfaces\Course\CourseTaskInterface;
use App\Contracts\Interfaces\Course\CourseVoucherInterface;
use App\Contracts\Interfaces\Course\ModuleInterface;
use App\Contracts\Interfaces\Course\ModuleQuestionInterface;
use App\Contracts\Interfaces\Course\QuizInterface;
use App\Contracts\Interfaces\Course\SubCategoryInterface;
use App\Contracts\Interfaces\Course\SubmissionTaskInterface;
use App\Contracts\Interfaces\Course\SubModuleInterface;
use App\Contracts\Interfaces\Course\UserCourseInterface;
use App\Contracts\Interfaces\RegisterInterface;
use App\Contracts\Repositories\Auth\ProfileRepository;
use App\Contracts\Repositories\Auth\UserRepository;
use App\Contracts\Repositories\Course\CategoryRepository;
use App\Contracts\Repositories\Course\CourseRepository;
use App\Contracts\Repositories\Course\CourseReviewRepository;
use App\Contracts\Repositories\Course\CourseTaskRepository;
use App\Contracts\Repositories\Course\CourseVoucherRepository;
use App\Contracts\Repositories\Course\ModuleQuestionRepository;
use App\Contracts\Repositories\Course\ModuleRepository;
use App\Contracts\Repositories\Course\QuizRepository;
use App\Contracts\Repositories\Course\SubCategoryRepository;
use App\Contracts\Repositories\Course\SubmissionTaskRepository;
use App\Contracts\Repositories\Course\SubModuleRepository;
use App\Contracts\Repositories\Course\UserCourseRepository;
use App\Contracts\Repositories\RegisterRepository;
use Illuminate\Support\ServiceProvider;

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
        CourseTaskInterface::class => CourseTaskRepository::class,
        SubmissionTaskInterface::class => SubmissionTaskRepository::class,
        UserCourseInterface::class => UserCourseRepository::class,
        CourseVoucherInterface::class => CourseVoucherRepository::class,
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
