<?php

namespace App\Contracts\Interfaces;

use App\Contracts\Interfaces\Eloquent\CustomPaginationInterface;
use App\Contracts\Interfaces\Eloquent\DeleteInterface;
use App\Contracts\Interfaces\Eloquent\GetInterface;
use App\Contracts\Interfaces\Eloquent\GetWhereInterface;
use App\Contracts\Interfaces\Eloquent\ShowInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\UpdateInterface;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

interface ChallengeSubmitInterface extends GetInterface, ShowInterface, StoreInterface, UpdateInterface, DeleteInterface, GetWhereInterface
{
    public function getByStudent(array $data): mixed;
    public function getByStudentFirst(array $data): mixed;
    public function getByMentor(mixed $id): mixed;
    public function getByTeacher(mixed $id): mixed;
    public function updateByChallenge(mixed $challenge_id, mixed $student_id, array $data): mixed;
    public function paginateSubmit(Request $request, mixed $id, int $pagination = 10): LengthAwarePaginator;
}
