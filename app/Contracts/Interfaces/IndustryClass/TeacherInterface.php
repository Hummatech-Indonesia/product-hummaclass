<?php

namespace App\Contracts\Interfaces\IndustryClass;

use App\Contracts\Interfaces\Eloquent\CustomPaginationInterface;
use App\Contracts\Interfaces\Eloquent\DeleteInterface;
use App\Contracts\Interfaces\Eloquent\GetWhereInterface;
use App\Contracts\Interfaces\Eloquent\SearchInterface;
use App\Contracts\Interfaces\Eloquent\ShowInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\UpdateInterface;

interface TeacherInterface extends SearchInterface, StoreInterface, ShowInterface, UpdateInterface, DeleteInterface, GetWhereInterface, CustomPaginationInterface
{
    
    /**
     * first
     *
     * @param  mixed $data
     * @return mixed
     */
    public function first(array $data): mixed;
}
