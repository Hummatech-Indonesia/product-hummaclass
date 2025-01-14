<?php

namespace App\Observers;

use App\Models\AssessmentForm;
use Faker\Provider\Uuid;

class AssesmentFormObserver
{
    /**
     * Handle the AssessmentForm "created" event.
     */
    public function creating(AssessmentForm $assessmentForm): void
    {
        $assessmentForm->id = Uuid::uuid();
    }
}
