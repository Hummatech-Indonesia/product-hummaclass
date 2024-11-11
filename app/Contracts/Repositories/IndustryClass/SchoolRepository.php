<?php

namespace App\Contracts\Repositories\IndustryClass;

use App\Contracts\Interfaces\IndustryClass\SchoolInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class SchoolRepository extends BaseRepository implements SchoolInterface
{
    public function __construct(School $school)
    {
        $this->model = $school;
    }

    public function customPaginate(Request $request, int $pagination = 10): LengthAwarePaginator
    {
        return $this->model->query()->fastPaginate($pagination);
    }

    /**
     * showWithSlug
     *
     * @param  mixed $slug
     * @return mixed
     */
    public function showWithSlug(string $slug): mixed
    {
        return $this->model->query()->where('slug', $slug)->firstOrFail();
    }

    /**
     * Method get
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
