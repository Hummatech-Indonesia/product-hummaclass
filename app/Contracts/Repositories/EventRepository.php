<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\EventInterface;
use App\Contracts\Interfaces\RegisterInterface;
use App\Contracts\Interfaces\UserInterface;
use App\Enums\UserRoleEnum;
use App\Helpers\UserHelper;
use App\Models\Event;
use App\Models\User;
use App\Traits\Datatables\UserDatatable;
use Illuminate\Http\Request;

class EventRepository extends BaseRepository implements EventInterface
{
    public function __construct(Event $event)
    {
        $this->model = $event;
    }
    public function customPaginate(Request $request, int $pagination = 10): \Illuminate\Pagination\LengthAwarePaginator
    {
        return $this->model->query()
            ->when($request->search, function ($query) use ($request) {
                $query->where('title', 'LIKE', '%' . $request->search . '%');
            })

            ->when($request->filter, function ($query) {
                $query->latest('start_date');
            })
            ->orderBy('created_at', 'desc')
            ->fastPaginate($pagination);
    }

    /**
     * get
     *
     * @return mixed
     */
    public function get(): mixed
    {
        return $this->model->query()->get();
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
     * Method show
     *
     * @param mixed $id [explicite description]
     *
     * @return mixed
     */
    public function show(mixed $id): mixed
    {
        return $this->model->query()->find($id);
    }
    /**
     * Method showWithSlug
     *
     * @param string $slug [explicite description]
     *
     * @return mixed
     */
    public function showWithSlug(string $slug): mixed
    {
        return $this->model->query()->where('slug', $slug)->firstOrFail();
    }
    /**
     * Method update
     *
     * @param mixed $id [explicite description]
     * @param array $data [explicite description]
     *
     * @return mixed
     */
    public function update(mixed $id, array $data): mixed
    {
        return $this->show($id)->update($data);
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
