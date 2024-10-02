<?php

namespace App\Observers;

use App\Models\CourseTest;
use Faker\Provider\Uuid;

class CourseTestObserver
{    
    /**
     * Method creating
     *
     * @param CourseTest $courseTest [explicite description]
     *
     * @return void
     */
    public function creating(CourseTest $courseTest): void
    {
        $courseTest->id = Uuid::uuid();
    }
}
