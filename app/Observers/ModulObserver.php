<?php

namespace App\Observers;

use App\Models\Modul;
use Faker\Provider\Uuid;
use Illuminate\Support\Str;


class ModulObserver
{
    /**
     * Handle the Modul "created" event.
     */
    public function creating(Modul $modul): void
    {
        $modul->id = Uuid::uuid();
        $modul->slug = Str::slug($modul->title);
    }

    /**
     * Handle the Modul "updated" event.
     */
    public function updating(Modul $modul): void
    {
        $modul->slug = Str::slug($modul->title);
    }
}
