<?php

namespace App\Observers;

use App\Models\Teacher;
use Faker\Provider\Uuid;

class TeacherObserver
{
    public function creating(Teacher $teacher): void
    {
        $teacher->id = Uuid::uuid();
    }
}
