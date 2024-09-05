<?php

namespace App\Observers;

use App\Models\SubmissionTask;
use Faker\Provider\Uuid;

class SubmissionTaskObserver
{    
    /**
     * Method creating
     *
     * @param SubmissionTask $submissionTask [explicite description]
     *
     * @return void
     */
    public function creating(SubmissionTask $submissionTask): void
    {
        $submissionTask->id = Uuid::uuid();
    }
}
