<?php

namespace App\Contracts\Interfaces\IndustryClass;

use App\Contracts\Interfaces\Eloquent\CustomPaginationInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

interface StudentClassroomInterface extends CustomPaginationInterface, StoreInterface
{
    public function delete_all(string $classroom_id): mixed;
    public function listStudentPaginate(Request $request, mixed $id, int $pagination = 10): LengthAwarePaginator;
}
