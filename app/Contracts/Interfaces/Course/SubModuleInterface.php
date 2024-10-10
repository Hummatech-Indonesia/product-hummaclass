<?php

namespace App\Contracts\Interfaces\Course;

use App\Contracts\Interfaces\Eloquent\BaseInterface;
use App\Contracts\Interfaces\Eloquent\CustomPaginationInterface;
use App\Contracts\Interfaces\Eloquent\DeleteInterface;
use App\Contracts\Interfaces\Eloquent\ShowInterface;
use App\Contracts\Interfaces\Eloquent\ShowSlugInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\UpdateInterface;

interface SubModuleInterface extends CustomPaginationInterface, StoreInterface, UpdateInterface, ShowInterface, DeleteInterface, ShowSlugInterface
{
    /**
     * getOneByModul
     *
     * @param  mixed $id
     * @return mixed
     */
    public function getOneByModul(string $id): mixed;

    /**
     * nextSubModule
     *
     * @return void
     */
    public function nextSubModule(mixed $step, mixed $module_id): mixed;
    /**
     * Method prevSubModule
     *
     * @param mixed $step [explicite description]
     * @param mixed $module_id [explicite description]
     *
     * @return mixed
     */
    public function prevSubModule(mixed $step, mixed $module_id): mixed;


    /**
     * getAllPrevSubModule
     *
     * @param  mixed $step
     * @param  mixed $module_id
     * @return mixed
     */
    public function getAllPrevSubModule(mixed $step, mixed $module_id): mixed;
}
