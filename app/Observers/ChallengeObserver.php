<?php

namespace App\Observers;

use App\Models\Challenge;
use Faker\Provider\Uuid;
use Illuminate\Support\Str;

class ChallengeObserver
{
    public function creating(Challenge $challenge): void
    {
        $challenge->id = Uuid::uuid();
        $challenge->slug = Str::slug($challenge->title);
    }

    public function updating(Challenge $challenge): void
    {
        $challenge->slug = Str::slug($challenge->title);
    }
}
