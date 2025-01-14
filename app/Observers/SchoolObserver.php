<?php

namespace App\Observers;

use App\Models\School;
use Faker\Provider\Uuid;
use Illuminate\Support\Str;

class SchoolObserver
{
    public function creating(School $school): void
    {
        $school->id = Uuid::uuid();
        $school->slug = Str::slug($school->name);
    }
    public function updating(School $school):void{
        $school->slug = Str::slug($school->name);
    }
}
