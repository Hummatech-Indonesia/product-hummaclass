<?php

namespace App\Observers;

use App\Models\SubModule;
use Faker\Provider\Uuid;
use Illuminate\Support\Str;
class SubModuleObserver
{
    /**
     * Method creating
     *
     * @param SubModule $subModule [explicite description]
     *
     * @return void
     */
    public function creating(SubModule $subModule): void
    {
        $subModule->id = Uuid::uuid();
        $subModule->slug = Str::slug($subModule->title);
    }
    /**
     * Method updating
     *
     * @param SubModule $subModule [explicite description]
     *
     * @return void
     */
    public function updating(SubModule $subModule): void
    {
        $subModule->slug = Str::slug($subModule->title);
    }
}
