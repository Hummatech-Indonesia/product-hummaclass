<?php

namespace App\Observers;

use App\Models\ModuleQuestion;
use Faker\Provider\Uuid;

class ModuleQuestionObserver
{
    /**
     * Method creating
     *
     * @param ModuleQuestion $moduleQuestion [explicite description]
     *
     * @return void
     */
    public function creating(ModuleQuestion $moduleQuestion): void
    {
        $moduleQuestion->id = Uuid::uuid();
    }
}
