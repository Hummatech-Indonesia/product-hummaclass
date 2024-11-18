<?php

namespace App\Contracts\Interfaces\Configuration;

use App\Contracts\Interfaces\Eloquent\BaseInterface;
use App\Contracts\Interfaces\Eloquent\GetInterface;
use App\Contracts\Interfaces\Eloquent\ShowInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\UpdateInterface;

interface ContactInterface
{
    /**
     * Method show
     *
     * @return mixed
     */
    public function show(): mixed;
    /**
     * Method update
     *
     * @param array $data [explicite description]
     *
     * @return mixed
     */
    public function update(array $data): mixed;
}
