<?php

namespace App\Contracts\Interfaces\Auth;

use App\Contracts\Interfaces\Eloquent\BaseInterface;
use App\Contracts\Interfaces\Eloquent\SearchInterface;
use App\Contracts\Interfaces\Eloquent\ShowInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;

interface UserInterface extends SearchInterface,ShowInterface
{

}
