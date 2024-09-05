<?php

namespace App\Observers;

use App\Models\CourseTask;
use Faker\Provider\Uuid;

class CourseTaskObserver
{    
    /**
     * Method creating
     *
     * @param CourseTask $courseTask [explicite description]
     *
     * @return void
     */
    public function creating(CourseTask $courseTask): void
    {
        $courseTask->id = Uuid::uuid();
    }
}
