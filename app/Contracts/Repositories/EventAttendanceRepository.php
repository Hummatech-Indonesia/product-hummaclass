<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\EventAttendanceInterface;
use App\Models\Event;
use App\Models\EventAttendance;

class EventAttendanceRepository extends BaseRepository implements EventAttendanceInterface
{
    public function __construct(EventAttendance $eventAttendance)
    {
        $this->model = $eventAttendance;
    }
    /**
     * Method show
     *
     * @param mixed $id [explicite description]
     *
     * @return mixed
     */
    public function show(mixed $id): mixed
    {
        return $this->model->query()->findOrFail($id);
    }
    /**
     * Method store
     *
     * @param array $data [explicite description]
     *
     * @return mixed
     */
    public function store(array $data): mixed
    {
        return $this->model->query()->create($data);
    }
    /**
     * Method delete
     *
     * @param mixed $id [explicite description]
     *
     * @return mixed
     */
    public function delete(mixed $id): mixed
    {
        return $this->show($id)->delete();
    }
}
