<?php

namespace App\Observers;

use App\Models\LearningPath;
use Faker\Provider\Uuid;

class LearningPathObserver
{
    /**
     * Method creating
     *
     * @param LearningPath $learningPath [explicite description]
     *
     * @return void
     */
    public function creating(LearningPath $learningPath): void
    {
        $learningPath->id = Uuid::uuid();
    }
}
