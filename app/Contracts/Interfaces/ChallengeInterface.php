<?php

namespace App\Contracts\Interfaces;

use App\Contracts\Interfaces\Eloquent\CustomPaginationInterface;
use App\Contracts\Interfaces\Eloquent\DeleteInterface;
use App\Contracts\Interfaces\Eloquent\GetInterface;
use App\Contracts\Interfaces\Eloquent\ShowInterface;
use App\Contracts\Interfaces\Eloquent\ShowSlugInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\UpdateInterface;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

interface ChallengeInterface extends GetInterface, ShowInterface, StoreInterface, UpdateInterface, DeleteInterface, ShowSlugInterface, CustomPaginationInterface
{
    public function getByClassroom(Request $request, string $classroomSlug, mixed $data, int $pagination = 10): LengthAwarePaginator;
}
