<?php

namespace App\Observers;

use App\Models\Challenge;
use Faker\Provider\Uuid;

class ChallengeObserver
{
    public function creating(Challenge $challenge): void
    {
        $challenge->id = Uuid::uuid();
    }
}
