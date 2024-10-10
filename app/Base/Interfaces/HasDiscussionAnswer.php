<?php

namespace App\Base\Interfaces;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface HasDiscussionAnswer
{
    /**
     * Method course
     *
     * @return BelongsTo
     */
    public function discussionAnswer(): BelongsTo;
}
