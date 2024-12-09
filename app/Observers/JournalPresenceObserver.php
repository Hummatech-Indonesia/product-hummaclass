<?php

namespace App\Observers;

use App\Models\JournalPresence;
use Faker\Provider\Uuid;

class JournalPresenceObserver
{
    public function creating(JournalPresence $journalPresence): void
    {
        $journalPresence->id = Uuid::uuid();
    }
}
