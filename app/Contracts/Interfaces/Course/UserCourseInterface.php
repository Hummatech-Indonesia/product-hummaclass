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
     * showByUserCourse
     *
     * @param  mixed $userId
     * @param  mixed $courseId
     * @return mixed
     */
    public function showByUserCourse($userId, $courseId): mixed;

}
