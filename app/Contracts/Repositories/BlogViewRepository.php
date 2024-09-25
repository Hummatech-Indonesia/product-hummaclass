<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\BlogInterface;
use App\Contracts\Interfaces\BlogViewInterface;
use App\Contracts\Interfaces\EventDetailInterface;
use App\Contracts\Interfaces\EventInterface;
use App\Contracts\Interfaces\RegisterInterface;
use App\Contracts\Interfaces\UserInterface;
use App\Enums\UserRoleEnum;
use App\Helpers\UserHelper;
use App\Models\Blog;
use App\Models\BlogView;
use App\Models\Event;
use App\Models\EventDetail;
use App\Models\User;
use App\Traits\Datatables\UserDatatable;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class BlogViewRepository extends BaseRepository implements BlogViewInterface
{
    public function __construct(BlogView $blogView)
    {
        $this->model = $blogView;
    }
    public function store(array $data):mixed{
        return $this->model->query()->create($data);
    }
}