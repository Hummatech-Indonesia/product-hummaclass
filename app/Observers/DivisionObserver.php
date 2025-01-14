<?php

namespace App\Observers;

use App\Models\Division;
use Faker\Provider\Uuid;

class DivisionObserver
{
    /**
     * Method creating
     *
     * @param Division $division [explicite description]
     *
     * @return void
     */
    public function creating(Division $division): void
    {
        $division->id = Uuid::uuid();
    }
}
