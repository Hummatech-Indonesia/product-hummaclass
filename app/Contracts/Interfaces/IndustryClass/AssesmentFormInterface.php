<?php

namespace App\Contracts\Interfaces\IndustryClass;

use App\Contracts\Interfaces\Eloquent\DeleteInterface;
use App\Contracts\Interfaces\Eloquent\GetWhereInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;

interface AssesmentFormInterface extends StoreInterface, GetWhereInterface
{
    /**
     * deleteWhere
     *
     * @param  mixed $data
     * @return mixed
     */
    public function deleteWhere(array $data): mixed;
}
