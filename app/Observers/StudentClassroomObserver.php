<?php

namespace App\Observers;

use App\Models\StudentClassroom;
use Faker\Provider\Uuid;

class StudentClassroomObserver
{
    /**
     * Handle the StudentClassroom "created" event.
     */
    public function creating(StudentClassroom $studentClassroom): void
    {
        $studentClassroom->id = Uuid::uuid();
    }
}
