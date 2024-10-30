<?php

namespace App\Base\Interfaces;

use App\Contracts\Interfaces\Eloquent\DeleteInterface;
use App\Contracts\Interfaces\Eloquent\GetInterface;
use App\Contracts\Interfaces\Eloquent\ShowInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Models\Event;

interface EventAttendanceInterface extends ShowInterface, StoreInterface, DeleteInterface
{
    public function get(Event $event): mixed
}