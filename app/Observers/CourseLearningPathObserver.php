<?php

namespace App\Observers;

use App\Models\CourseLearningPath;
use Faker\Provider\Uuid;

class CourseLearningPathObserver
{
    /**
     * Method creating
     *
     * @param CourseLearningPath $courseLearningPath [explicite description]
     *
     * @return void
     */
    public function creating(CourseLearningPath $courseLearningPath): void
    {
        $courseLearningPath->id = Uuid::uuid();
    }
}
