<?php

namespace App\Contracts\Interfaces\Course;

use App\Contracts\Interfaces\Eloquent\GetInterface;
use App\Contracts\Interfaces\Eloquent\ShowInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;

interface CourseTestInterface extends GetInterface, StoreInterface, ShowInterface
{
}