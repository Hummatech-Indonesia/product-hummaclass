<?php

namespace App\Contracts\Interfaces\IndustryClass;

use App\Contracts\Interfaces\Eloquent\DeleteInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\UpdateInterface;

interface JournalPresenceInterface extends StoreInterface, DeleteInterface
{   
    public function update(mixed $journal_id, mixed $student_classroom_id, array $data): mixed;
}