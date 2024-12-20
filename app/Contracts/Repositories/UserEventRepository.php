<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\Course\UserEventInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\UserEvent;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class UserEventRepository extends BaseRepository implements UserEventInterface
{
    public function __construct(UserEvent $userEvent)
    {
        $this->model = $userEvent;
    }
    /**
     * Method customPaginate
     *
     * @param Request $request [explicite description]
     * @param int $pagination [explicite description]
     *
     * @return LengthAwarePaginator
     */
    public function customPaginate(Request|null $request, int $pagination = 10): LengthAwarePaginator
    {
        return $this->model->query()->with(['event' => function ($query) {
            $query->withCount('userEvents');
        }, 'user'])
            ->when($request->event_id, function ($query) use ($request) {
                $query->where('event_id', $request->event_id);
            })
            ->where('user_id', auth()->user()->id)->fastPaginate($pagination);
    }

    /**
     * store
     *
     * @param  mixed $data
     * @return mixed
     */
    public function store(array $data): mixed
    {
        return $this->model->query()->create($data);
    }
    /**
     * delete
     *
     * @param  mixed $id
     * @return mixed
     */
    public function delete(mixed $id): mixed
    {
        return $this->model->show($id)->delete();
    }
    /**
     * show
     *
     * @param  mixed $id
     * @return mixed
     */
    public function show(mixed $id): mixed
    {
        return $this->model->query()->findOrFail($id);
    }

    /**
     * update
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return mixed
     */
    public function update(mixed $id, array $data): mixed
    {
        return $this->model->query()->where('user_id', auth()->user()->id)->where('event_id', $id)->firstOrFail()->update($data);
    }
    /**
     * showByCourse
     *
     * @param  mixed $userId
     * @param  mixed $courseId
     * @return mixed
     */
    public function showByEvent($userId, $eventId): mixed
    {
        // return [$userId, $eventId];
        return $this->model->query()->where('user_id', $userId)->where('event_id', $eventId)->firstOrFail();
    }
}
