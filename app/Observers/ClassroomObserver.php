<?php

namespace App\Observers;

use App\Models\Classroom;
use Faker\Provider\Uuid;
use Illuminate\Support\Str;

class ClassroomObserver
{
    public function creating(Classroom $classroom): void
    {
        $classroom->id = Uuid::uuid();
        $classroom->slug = Str::slug($classroom->name);
    }

    public function updating(Classroom $classroom): void
    {
        $classroom->slug = Str::slug($classroom->name);
    }
}
