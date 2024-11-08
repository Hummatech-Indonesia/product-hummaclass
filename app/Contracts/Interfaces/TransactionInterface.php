<?php

namespace App\Contracts\Interfaces;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Contracts\Interfaces\Eloquent\BaseInterface;
use App\Contracts\Interfaces\Eloquent\CustomPaginationInterface;
use App\Contracts\Interfaces\Eloquent\ShowInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\DeleteInterface;
use App\Contracts\Interfaces\Eloquent\GetInterface;
use App\Contracts\Interfaces\Eloquent\GetWhereInterface;
use App\Contracts\Interfaces\Eloquent\SearchInterface;
use App\Contracts\Interfaces\Eloquent\UpdateInterface;

interface TransactionInterface extends GetInterface, GetWhereInterface, StoreInterface, UpdateInterface, DeleteInterface, ShowInterface, CustomPaginationInterface, SearchInterface
{
    public function countByMonth(): mixed;    
    /**
     * Method getLatest
     *
     * @return mixed
     */
    public function getLatest(): mixed;
}
