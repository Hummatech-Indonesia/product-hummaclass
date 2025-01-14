<?php

namespace App\Observers;

use App\Models\Journal;
use Faker\Provider\Uuid;

class JournalObserver
{
    public function creating(Journal $journal): void
    {
        $journal->id = Uuid::uuid();
    }
}
