<?php

namespace App\Contracts\Interfaces\IndustryClass;

use App\Contracts\Interfaces\Eloquent\BaseInterface;
use App\Contracts\Interfaces\Eloquent\CustomPaginationInterface;
use App\Contracts\Interfaces\Eloquent\FirstInterface;
use App\Contracts\Interfaces\Eloquent\GetWhereInterface;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

interface StudentInterface extends GetWhereInterface, BaseInterface, CustomPaginationInterface, FirstInterface
{

    /**
     * getWithout
     *
     * @return mixed
     */
    public function getWithout(string $school_id): mixed;
    public function listRangePoint(Request $request, int $pagination = 10): LengthAwarePaginator;
    public function userPoint(): mixed;
}
