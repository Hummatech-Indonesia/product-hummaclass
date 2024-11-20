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
        $user->name = htmlspecialchars($user->name);
        $user->email = htmlspecialchars($user->email);
        $user->address = htmlspecialchars($user->address);
        $user->phone_number = htmlspecialchars($user->phone_number);
    }

    /**
     * updating
     *
     * @param  mixed $user
     * @return void
     */
    public function updating(User $user): void
    {
        $user->name = htmlspecialchars($user->name);
        $user->email = htmlspecialchars($user->email);
        $user->address = htmlspecialchars($user->address);
        $user->phone_number = htmlspecialchars($user->phone_number);
    }
}
