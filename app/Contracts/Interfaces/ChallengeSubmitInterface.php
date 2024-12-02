<?php

namespace App\Contracts\Interfaces;

use App\Contracts\Interfaces\Eloquent\DeleteInterface;
use App\Contracts\Interfaces\Eloquent\GetInterface;
use App\Contracts\Interfaces\Eloquent\GetWhereInterface;
use App\Contracts\Interfaces\Eloquent\ShowInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\UpdateInterface;

interface ChallengeSubmitInterface extends GetInterface, ShowInterface, StoreInterface, UpdateInterface, DeleteInterface
{
    public function getByStudent(array $data): mixed;
    public function getByMentor(mixed $id): mixed;
    public function getByTeacher(mixed $id): mixed;
}
