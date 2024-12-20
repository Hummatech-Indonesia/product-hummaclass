<?php

namespace App\Base\Interfaces;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface HasSubCategory
{

    /**
     * One-to-Many relationship with User Model
     *
     * @return BelongsTo
     */

    public function subCategory(): BelongsTo;
}
