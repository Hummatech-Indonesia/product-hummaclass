<?php

namespace App\Services\IndustryClass;

use Illuminate\Pagination\LengthAwarePaginator;

class StudentService 
{
    /**
     * store
     *
     * @param  mixed $request
     * @return array
     */
    public function paginate($query, int $pagination = 10): LengthAwarePaginator
    {
        return $query->fastPaginate($pagination);
    }
}
