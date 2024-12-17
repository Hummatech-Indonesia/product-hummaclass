<?php

namespace App\Observers;

use App\Models\Zoom;
use Faker\Provider\Uuid;
use Illuminate\Support\Str;

class ZoomObserver
{
    public function creating(Zoom $zoom): void
    {
        $zoom->id = Uuid::uuid();
        $zoom->slug = Str::slug($zoom->title);
    }

    public function updating(Zoom $zoom): void
    {
        $zoom->slug = Str::slug($zoom->title);
    }
}
