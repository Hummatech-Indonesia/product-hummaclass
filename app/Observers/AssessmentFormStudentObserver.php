<?php

namespace App\Observers;

use App\Models\AssesmentFormStudent;
use Faker\Provider\Uuid;

class AssessmentFormStudentObserver
{
    /**
     * Method creating
     *
     * @param AssesmentFormStudent $assesmentFormStudent [explicite description]
     *
     * @return void
     */
    public function creating(AssesmentFormStudent $assesmentFormStudent): void
    {
        $assesmentFormStudent->id = Uuid::uuid();
    }
}
