<?php

namespace App\Contracts\Interfaces\Auth;

use App\Contracts\Interfaces\Eloquent\BaseInterface;
use App\Contracts\Interfaces\Eloquent\CustomPaginationInterface;
use App\Contracts\Interfaces\Eloquent\DeleteInterface;
use App\Contracts\Interfaces\Eloquent\SearchInterface;
use App\Contracts\Interfaces\Eloquent\ShowInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\UpdateInterface;

interface UserInterface extends CustomPaginationInterface, ShowInterface, UpdateInterface, StoreInterface, DeleteInterface
{
    /**
     * Method customUpdate
     *
     * @param mixed $id [explicite description]
     * @param array $data [explicite description]
     *
     * @return mixed
     */
    public function customUpdate(mixed $id, array $data): mixed;

    /**
     * Method countUsersbyMonth
     *
     * @return array
     */
    public function countUsersbyMonth(): array;


    /**
     * getMentor
     *
     * @return array
     */
    public function getMentor(): mixed;
}
