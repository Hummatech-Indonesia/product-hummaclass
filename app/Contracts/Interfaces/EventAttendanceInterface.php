<?php

namespace App\Contracts\Interfaces;

use Illuminate\Http\Request;
use App\Contracts\Interfaces\Eloquent\ShowInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\DeleteInterface;

interface EventAttendanceInterface extends ShowInterface, StoreInterface, DeleteInterface
{
    public function get(Request $request, $event): mixed;
}
