<?php

namespace App\Providers;

use App\Models\Course;
use App\Models\Modul;
use App\Models\Module;
use App\Models\ModuleQuestion;
use App\Models\Quiz;
use App\Models\SubModule;
use App\Models\User;
use App\Observers\CourseObserver;
use App\Observers\ModuleObserver;
use App\Observers\ModuleQuestionObserver;
use App\Observers\ModulObserver;
use App\Observers\QuizObserver;
use App\Observers\SubModuleObserver;
use App\Observers\UserObserver;
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
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
