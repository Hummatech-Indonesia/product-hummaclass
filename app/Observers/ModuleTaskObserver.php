<?php

namespace App\Observers;

use App\Models\ModuleTask;
use Faker\Provider\Uuid;

class ModuleTaskObserver
{
    /**
     * Method creating
     *
     * @param ModuleTask $moduleTask [explicite description]
     *
     * @return void
     */
    public function creating(ModuleTask $moduleTask): void
    {
        $moduleTask->id = Uuid::uuid();
    }
}
