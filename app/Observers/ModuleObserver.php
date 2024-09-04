<?php

namespace App\Observers;

use App\Models\Module;
use Faker\Provider\Uuid;
use Illuminate\Support\Str;

class ModuleObserver
{
    /**
     * Method creating
     *
     * @param Module $module [explicite description]
     *
     * @return void
     */
    public function creating(Module $module): void
    {
        $module->id = Uuid::uuid();
        $module->slug = Str::slug($module->title);
    }
}
