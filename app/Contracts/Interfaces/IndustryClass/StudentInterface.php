<?php

namespace App\Contracts\Interfaces\IndustryClass;

use App\Contracts\Interfaces\Eloquent\BaseInterface;
use App\Contracts\Interfaces\Eloquent\CustomPaginationInterface;
use App\Contracts\Interfaces\Eloquent\GetWhereInterface;
use Illuminate\Http\Request;

interface StudentInterface extends GetWhereInterface, BaseInterface, CustomPaginationInterface
{

    /**
     * getWithout
     *
     * @return mixed
     */
    public function getWithout(string $school_id): mixed;
}
