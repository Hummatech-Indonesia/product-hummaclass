<?php

namespace App\Contracts\Interfaces;

use App\Contracts\Interfaces\Eloquent\GetInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;

interface SuperiorFeatureInterface extends GetInterface
{
    /**
     * Method update
     *
     * @param array $data [explicite description]
     *
     * @return mixed
     */
    public function update(array $data): mixed;
}
