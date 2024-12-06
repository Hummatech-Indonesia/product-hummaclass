<?php

namespace App\Contracts\Repositories\IndustryClass;

use App\Contracts\Interfaces\IndustryClass\ZoomInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Contracts\Repositories\BaseRepository;
use Illuminate\Http\Request;
use App\Models\Zoom;

class ZoomRepository extends BaseRepository implements ZoomInterface
{
    public function __construct(Zoom $zoom)
    {
        $this->model = $zoom;
    }

    public function customPaginate(Request $request, int $pagination = 10): LengthAwarePaginator
    {
        return $this->model->query()
            ->when($request->search, function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->search . '%')
                    ->orWhereRelqtion('user', 'name', 'like', '%' . $request->search . '%')
                    ->orWhereRelation('classroom', 'name', 'like', '%' . $request->search . '%')
                    ->orWhererelation('school', 'name', 'like', '%' . $request->search . '%');
            })
            ->latest()
            ->fastPaginate($pagination);
    }


    /**
     * getWhere
     *
     * @param  mixed $data
     * @return mixed
     */
    public function getWhere(array $data): mixed
    {
        return $this->model->query()->where($data)->get();
    }

    public function get(): mixed
    {
        return $this->model->query()->get();
    }

    /**
     * Method get
     *
     * @return mixed
     */
    public function search(Request $request): mixed
    {
        return $this->model->query()->when($request->school_id, function ($query) use ($request) {
            $query->where('school_id', $request->school_id);
        })->get();
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
        return $this->model->query()->findOrFail($id);
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
