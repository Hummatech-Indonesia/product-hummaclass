<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\EventInterface;
use App\Contracts\Interfaces\RegisterInterface;
use App\Contracts\Interfaces\UserEventAttendanceInterface;
use App\Contracts\Interfaces\UserInterface;
use App\Enums\UserRoleEnum;
use App\Helpers\UserHelper;
use App\Models\Event;
use App\Models\User;
use App\Models\UserEventAttendance;
use App\Traits\Datatables\UserDatatable;
use Illuminate\Http\Request;

class UserEventAttendanceRepository extends BaseRepository implements UserEventAttendanceInterface
{
    public function __construct(UserEventAttendance $userEventAttendance)
    {
        $this->model = $userEventAttendance;
    }
    public function getWhere(array $data): mixed
    {
        return $this->model->query()->where($data)->get();
    }
    public function get($event): mixed
    {
        return $this->model->whereHas('eventAttendance', function ($query) use ($event) {
            $query->where('event_id', $event->id);
        })->get();
    }
    public function store(array $data): mixed
    {
        return $this->model->query()->create($data);
    }
}
