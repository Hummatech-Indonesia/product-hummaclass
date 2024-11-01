<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\EventAttendanceInterface;
use App\Models\Event;
use Hammerstone\FastPaginate\FastPaginate;
use App\Models\EventAttendance;
use Illuminate\Http\Request;

class EventAttendanceRepository extends BaseRepository implements EventAttendanceInterface
{
    public function __construct(EventAttendance $eventAttendance)
    {
        $this->model = $eventAttendance;
    }

    public function get(Request $request, $event): mixed
    {
        return $this->model->where('event_id', $event->id)->with('userEventAttendance')
            ->when($request->date, function ($query) use ($request) {
                $query->where('attendance_date', $request->date);
            })
            ->when($request->name, function ($query) use ($request) {
                $query->whereHas('userEventAttendance.user', function ($query) use ($request) {
                    $query->where('name', 'LIKE', '%' . $request->name . '%');
                });
            })
            ->fastPaginate(10);
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
