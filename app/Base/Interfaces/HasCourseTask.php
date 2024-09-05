<?php

namespace App\Base\Interfaces;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface HasCourseTask
{
    /**
     * Method courseTask
     *
     * @return BelongsTo
     */
    public function courseTask(): BelongsTo;
}
