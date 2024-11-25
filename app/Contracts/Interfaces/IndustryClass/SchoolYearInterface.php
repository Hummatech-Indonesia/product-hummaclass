<?php

namespace App\Contracts\Interfaces\IndustryClass;

use App\Contracts\Interfaces\Eloquent\DeleteInterface;
use App\Contracts\Interfaces\Eloquent\GetInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;

interface SchoolYearInterface extends GetInterface, StoreInterface, DeleteInterface
{

    /**
     * get
     *
     * @return mixed
     */
    public function getLatest(): mixed;
}
