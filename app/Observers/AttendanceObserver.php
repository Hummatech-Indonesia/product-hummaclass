<?php

namespace App\Observers;

use Faker\Provider\Uuid;
use App\Models\Attendance;
use Illuminate\Support\Str;

class AttendanceObserver
{
    public function creating(Attendance $attendance): void
    {
        $attendance->id = Uuid::uuid();
        $attendance->slug = Str::slug($attendance->title);
    }

    public function updating(Attendance $attendance): void
    {
        $attendance->slug = Str::slug($attendance->title);
    }
}
