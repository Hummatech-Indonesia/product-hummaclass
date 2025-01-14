<?php

namespace App\Observers;

use App\Models\Mentor;
use Faker\Provider\Uuid;

class MentorObserver
{
    public function creating(Mentor $mentor): void
    {
        $mentor->id = Uuid::uuid();
    }
}
