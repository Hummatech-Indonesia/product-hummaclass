<?php

namespace App\Contracts\Interfaces;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Contracts\Interfaces\Eloquent\BaseInterface;
use App\Contracts\Interfaces\Eloquent\ShowInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\DeleteInterface;
use App\Contracts\Interfaces\Eloquent\UpdateInterface;

interface TransactionInterface extends StoreInterface, UpdateInterface, DeleteInterface, ShowInterface {}
