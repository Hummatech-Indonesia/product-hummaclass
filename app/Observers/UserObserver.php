<?php

namespace App\Observers;

use App\Models\User;
use Faker\Provider\Uuid;

class UserObserver
{
    /**
     * Method creating
     *
     * @param User $user [explicite description]
     *
     * @return void
     */
    public function creating(User $user): void
    {
        $user->id = Uuid::uuid();
    }
}
