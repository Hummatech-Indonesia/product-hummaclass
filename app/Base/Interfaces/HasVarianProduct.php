<?php

namespace App\Base\Interfaces;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface HasVarianProduct
{

    /**
     * One-to-Many relationship with VarianProduct Model
     *
     * @return BelongsTo
     */

    public function varianProduct(): BelongsTo;
}
