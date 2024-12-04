<?php

namespace App\Contracts\Interfaces\IndustryClass;

use App\Contracts\Interfaces\Eloquent\GetWhereInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;

interface AssesmentFormInterface extends StoreInterface, GetWhereInterface {}
