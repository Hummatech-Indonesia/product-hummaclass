<?php

namespace App\Observers;

use App\Models\UserCourseTest;
use Faker\Provider\Uuid;

class UserCourseTestObserver
{    
    /**
     * Method creating
     *
     * @param UserCourseTest $userCourseTest [explicite description]
     *
     * @return void
     */
    public function creating(UserCourseTest $userCourseTest): void
    {
        $userCourseTest->id = Uuid::uuid();
    }
}
