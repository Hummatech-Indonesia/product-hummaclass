<?php

namespace App\Contracts\Interfaces\IndustryClass;

use App\Contracts\Interfaces\Eloquent\CustomPaginationInterface;
use App\Contracts\Interfaces\Eloquent\DeleteInterface;
use App\Contracts\Interfaces\Eloquent\GetInterface;
use App\Contracts\Interfaces\Eloquent\GetWhereInterface;
use App\Contracts\Interfaces\Eloquent\SearchInterface;
use App\Contracts\Interfaces\Eloquent\ShowInterface;
use App\Contracts\Interfaces\Eloquent\ShowSlugInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\UpdateInterface;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

interface ClassroomInterface extends GetInterface, StoreInterface, ShowInterface, UpdateInterface, DeleteInterface, ShowSlugInterface
{
    public function customPaginate(Request $request, mixed $query, int $pagination = 9): LengthAwarePaginator;
    public function search(mixed $query, Request $request): mixed;
    public function take(mixed $query, mixed $count): mixed;
    public function getWhere(array $data, $search): mixed;
    public function where(mixed $query) : mixed;
}
