<?php

namespace App\Contracts\Interfaces\Course;

use Illuminate\Http\JsonResponse;
use App\Contracts\Interfaces\Eloquent\GetInterface;
use App\Contracts\Interfaces\Eloquent\BaseInterface;
use App\Contracts\Interfaces\Eloquent\ShowInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\DeleteInterface;
use App\Contracts\Interfaces\Eloquent\SearchInterface;
use App\Contracts\Interfaces\Eloquent\UpdateInterface;
use App\Contracts\Interfaces\Eloquent\GetWhereInterface;
use App\Contracts\Interfaces\Eloquent\ShowSlugInterface;
use App\Contracts\Interfaces\Eloquent\CustomPaginationInterface;

interface CourseInterface extends CustomPaginationInterface, StoreInterface, UpdateInterface, ShowInterface, DeleteInterface, ShowSlugInterface, SearchInterface, GetInterface
{
    public function count(): mixed;    
}
