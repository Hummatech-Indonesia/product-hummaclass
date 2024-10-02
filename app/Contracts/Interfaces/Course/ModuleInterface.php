<?php

namespace App\Contracts\Interfaces\Course;

use App\Contracts\Interfaces\Eloquent\BaseInterface;
use App\Contracts\Interfaces\Eloquent\CustomPaginationInterface;
use App\Contracts\Interfaces\Eloquent\DeleteInterface;
use App\Contracts\Interfaces\Eloquent\GetWhereInterface;
use App\Contracts\Interfaces\Eloquent\SearchInterface;
use App\Contracts\Interfaces\Eloquent\ShowInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\UpdateInterface;

interface ModuleInterface extends CustomPaginationInterface, StoreInterface, ShowInterface, UpdateInterface, DeleteInterface, SearchInterface
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
    public function getForward(mixed $mixed, string $id): mixed;
    /**
     * Method getOneStepBackward
     *
     * @param mixed $mixed [explicite description]
     *
     * @return mixed
     */
    public function getBackward(mixed $mixed, string $id): mixed;
    /**
     * Method getWhere
     *
     * @param string $column [explicite description]
     * @param string $operator [explicite description]
     * @param $value $value [explicite description]
     *
     * @return mixed
     */
    public function getWhere(string $column, string $operator, $value): mixed;

    /**
     * moduleNextStep
     *
     * @return mixed
     */
    public function moduleNextStep(int $step): mixed;
    /**
     * Method modulePrevStep
     *
     * @param int $step [explicite description]
     *
     * @return mixed
     */
    public function modulePrevStep(int $step): mixed;
}
