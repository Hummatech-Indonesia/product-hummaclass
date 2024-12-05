<?php

namespace App\Contracts\Interfaces\IndustryClass;

use App\Contracts\Interfaces\Eloquent\GetWhereInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

interface AttendanceStudentInterface extends StoreInterface, GetWhereInterface
{
    public function customPaginate(Request $request, mixed $query, int $pagination = 10): LengthAwarePaginator;
}