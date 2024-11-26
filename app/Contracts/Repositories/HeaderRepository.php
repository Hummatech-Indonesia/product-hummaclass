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
        return $this->model->query()->firstOrFail();
    }
    /**
     * Method update
     *
     * @param array $data [explicite description]
     *
     * @return mixed
     */
    public function update(array $data): mixed
    {
        return $this->get()->update($data);
    }
}
