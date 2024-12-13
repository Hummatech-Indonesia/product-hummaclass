<?php

namespace App\Contracts\Interfaces\IndustryClass;

use App\Contracts\Interfaces\Eloquent\CustomPaginationInterface;
use App\Contracts\Interfaces\Eloquent\DeleteInterface;
use App\Contracts\Interfaces\Eloquent\GetInterface;
use App\Contracts\Interfaces\Eloquent\ShowInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\UpdateInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

interface JournalInterface extends GetInterface, StoreInterface, ShowInterface, UpdateInterface, DeleteInterface
{
    public function search(mixed $query, Request $request): mixed;

    public function customPaginate(mixed $query, Request $request, int $pagination = 10): LengthAwarePaginator;

}