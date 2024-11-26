<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\HeaderInterface;
use App\Models\Header;

class HeaderRepository extends BaseRepository implements HeaderInterface
{
    public function __construct(Header $header)
    {
        $this->model = $header;
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
