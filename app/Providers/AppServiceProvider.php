<?php

namespace App\Providers;

use App\Contracts\Interfaces\Course\CategoryInterface;
use App\Contracts\Interfaces\Course\SubCategoryInterface;
use App\Contracts\Interfaces\RegisterInterface;
use App\Contracts\Repositories\Course\CategoryRepository;
use App\Contracts\Repositories\Course\SubCategoryRepository;
use App\Contracts\Repositories\RegisterRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    private array $register = [
        RegisterInterface::class => RegisterRepository::class,
        CategoryInterface::class => CategoryRepository::class,
        SubCategoryInterface::class => SubCategoryRepository::class,
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
        //
    }
}
