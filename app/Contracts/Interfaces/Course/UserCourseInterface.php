<?php

namespace App\Contracts\Interfaces\Course;

use App\Contracts\Interfaces\Eloquent\BaseInterface;
use App\Contracts\Interfaces\Eloquent\CustomPaginationInterface;
use App\Contracts\Interfaces\Eloquent\DeleteInterface;
use App\Contracts\Interfaces\Eloquent\ShowInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\UpdateInterface;
use Illuminate\Http\Request;

interface UserCourseInterface extends CustomPaginationInterface, StoreInterface, DeleteInterface, ShowInterface, UpdateInterface
{
    /**
     * Method showByCourse
     *
     * @param $courseId $courseId [explicite description]
     *
     * @return mixed
     */
    public function showByCourse($courseId): mixed;

    /**
     * Method customUpdate
     *
     * @param mixed $courseId [explicite description]
     * @param array $data [explicite description]
     *
     * @return mixed
     */
    public function customUpdate(mixed $courseId, array $data): mixed;
}
