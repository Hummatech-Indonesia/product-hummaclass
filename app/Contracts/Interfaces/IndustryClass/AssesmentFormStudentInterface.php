<?php

namespace App\Contracts\Interfaces\IndustryClass;

use App\Contracts\Interfaces\Eloquent\StoreInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

interface AssesmentFormStudentInterface extends StoreInterface 
{
    public function getWhere(array $data): mixed;
    public function getStudentAssesment(Request $request, mixed $classroomId, int $pagination = 10): LengthAwarePaginator;
}
