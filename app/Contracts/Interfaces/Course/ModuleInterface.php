<?php

namespace App\Contracts\Interfaces\Course;

use App\Contracts\Interfaces\Eloquent\BaseInterface;
use App\Contracts\Interfaces\Eloquent\CustomPaginationInterface;
use App\Contracts\Interfaces\Eloquent\DeleteInterface;
use App\Contracts\Interfaces\Eloquent\ShowInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\UpdateInterface;

interface ModuleInterface extends CustomPaginationInterface, StoreInterface, ShowInterface, UpdateInterface, DeleteInterface
{
    /**
     * getOneByCourse
     *
     * @param  mixed $id
     * @return mixed
     */
    public function getOneByCourse(string $id): mixed;
}
