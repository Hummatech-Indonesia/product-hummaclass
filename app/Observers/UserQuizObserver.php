<?php

namespace App\Observers;

use App\Models\UserQuiz;
use Faker\Provider\Uuid;

class UserQuizObserver
{
    public function creating(UserQuiz $userQuiz): void
    {
        $userQuiz->id = Uuid::uuid();
    }
}
