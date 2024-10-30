<?php

namespace App\Contracts\Repositories;

use App\Base\Interfaces\EventAttendanceInterface;
use App\Models\Event;
use App\Models\EventAttendance;

class EventAttendanceRepository extends BaseRepository implements EventAttendanceInterface
{
    public function __construct(EventAttendance $model)
    {
        $this->model = $model;
    }

    public function get(Event $event): mixed
    {
        return $this->model->query()
            ->where('event_id', $event->id)
            ->fastPaginate();
    }

    public function store(array $data): mixed
    {
        return $this->model->query()->create($data);
    }
    public function show(mixed $id): mixed
    {
        return $this->model->query()->find($id);
    }
    public function delete(mixed $id): mixed
    {
        return $this->show($id)->delete();
    }
}
