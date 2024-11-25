<?php

namespace App\Contracts\Repositories\IndustryClass;

use App\Contracts\Interfaces\IndustryClass\SchoolYearInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\SchoolYear;

class SchoolYearRepository extends BaseRepository implements SchoolYearInterface
{
    public function __construct(SchoolYear $schoolYear)
    {
        $this->model = $schoolYear;
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
        return $this->model->query()->findOrFail($id)->delete();
    }

    /**
     * getLatest
     *
     * @return mixed
     */
    public function getLatest(): mixed
    {
        return $this->model->query()->latest()->firstOrFail();
    }
}
