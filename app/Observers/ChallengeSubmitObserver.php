<?php

namespace App\Observers;

use App\Models\ChallengeSubmit;
use Faker\Provider\Uuid;

class ChallengeSubmitObserver
{
    public function creating(ChallengeSubmit $challengeSubmit): void
    {
        $challengeSubmit->id = Uuid::uuid();
    }

}
