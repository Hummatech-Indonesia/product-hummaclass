<?php

namespace App\Base\Interfaces;

use Illuminate\Database\Eloquent\Relations\HasMany;

interface HasChallengeSubmits
{
    /**
     * Get all of the userCourses for the HasUserCourses
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function challengeSubmits(): HasMany;
}