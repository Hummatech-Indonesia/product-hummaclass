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

    /**
     * Method getOneStep
     *
     * @param mixed $mixed [explicite description]
     *
     * @return mixed
     */
    public function getForward(mixed $mixed): mixed;
    /**
     * Method getOneStepBackward
     *
     * @param mixed $mixed [explicite description]
     *
     * @return mixed
     */
    public function getBackward(mixed $mixed): mixed;
}
