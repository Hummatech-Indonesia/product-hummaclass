<?php

namespace App\Observers;

use App\Models\Course;
use Faker\Provider\Uuid;
use Illuminate\Support\Str;

class CourseObserver
{
    public function creating(Course $course): void
    {
        $course->id = Uuid::uuid();
        $course->slug = Str::slug($course->title);
    }
}
