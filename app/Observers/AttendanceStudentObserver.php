<?php

namespace App\Observers;

use Faker\Provider\Uuid;
use App\Models\AttendanceStudent;

class AttendanceStudentObserver
{
    public function creating(AttendanceStudent $attendanceStudent): void
    {
        $attendanceStudent->id = Uuid::uuid();
    }
}
