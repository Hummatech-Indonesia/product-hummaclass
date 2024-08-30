<?php

namespace App\Base\Interfaces;

use Illuminate\Database\Eloquent\Relations\HasMany;

interface HasVarianProducts
{

    /**
     * One-to-Many relationship with Product Questions Model
     *
     * @return HasMany
     */

    public function varianProducts(): HasMany;
}
