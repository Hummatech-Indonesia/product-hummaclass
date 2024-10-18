<?php

namespace App\Contracts\Interfaces\Course;

use App\Contracts\Interfaces\Eloquent\BaseInterface;
use App\Contracts\Interfaces\Eloquent\CustomPaginationInterface;
use App\Contracts\Interfaces\Eloquent\DeleteInterface;
use App\Contracts\Interfaces\Eloquent\GetWhereInterface;
use App\Contracts\Interfaces\Eloquent\ShowInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\UpdateInterface;
use Illuminate\Http\Request;

interface UserCourseInterface extends CustomPaginationInterface,GetWhereInterface, StoreInterface, DeleteInterface, ShowInterface, UpdateInterface
{
    /**
     * Method showByUserCourse
     *
     * @param $courseId $courseId [explicite description]
     *
     * @return mixed
     */
    public function showByUserCourse($courseId): mixed;

}
