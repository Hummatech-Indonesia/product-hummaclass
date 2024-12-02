<?php

namespace App\Contracts\Interfaces\IndustryClass;

use App\Contracts\Interfaces\Eloquent\DeleteInterface;
use App\Contracts\Interfaces\Eloquent\GetInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\UpdateInterface;

interface SchoolYearInterface extends GetInterface
{

    /**
     * Method store
     *
     * @return mixed
     */
    public function store(): mixed;

    /**
     * Method delete
     *
     * @return mixed
     */
    public function delete(): mixed;

}
