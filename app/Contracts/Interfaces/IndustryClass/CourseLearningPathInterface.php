<?php

namespace App\Contracts\Interfaces\IndustryClass;

use App\Contracts\Interfaces\Eloquent\DeleteInterface;
use App\Contracts\Interfaces\Eloquent\GetInterface;
use App\Contracts\Interfaces\Eloquent\GetWhereInterface;
use App\Contracts\Interfaces\Eloquent\ShowInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\UpdateInterface;

interface CourseLearningPathInterface extends GetInterface, StoreInterface, ShowInterface, UpdateInterface, DeleteInterface
{
    public function deleteWhere(array $data): mixed;
    public function whereCourse(mixed $course_id, mixed $learning_path_id): mixed;
}