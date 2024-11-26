<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\SuperiorFeatureInterface;
use App\Models\Header;
use App\Models\SuperiorFeature;

class SuperiorFeatureRepository extends BaseRepository implements SuperiorFeatureInterface
{
    public function __construct(SuperiorFeature $superiorFeature)
    {
        $this->model = $superiorFeature;
    }
    /**
     * Method get
     *
     * @return mixed
     */
    public function get(): mixed
    {
        return $this->model->query()->first();
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
        return $this->model->query()->updateOrCreate(['id' => 1], $data);
    }
}
