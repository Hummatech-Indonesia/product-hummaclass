<?php

namespace App\Contracts\Interfaces\Course;

use App\Contracts\Interfaces\Eloquent\BaseInterface;
use App\Contracts\Interfaces\Eloquent\CustomPaginationInterface;
use App\Contracts\Interfaces\Eloquent\DeleteInterface;
use App\Contracts\Interfaces\Eloquent\GetInterface;
use App\Contracts\Interfaces\Eloquent\ShowInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\UpdateInterface;

interface ModuleQuestionInterface extends CustomPaginationInterface,GetInterface, StoreInterface, UpdateInterface, ShowInterface, DeleteInterface
{
    /**
     * Handle the Get all data event from models.
     *
     * @return mixed
     */

    public function getByModule(string $id): mixed;
}
