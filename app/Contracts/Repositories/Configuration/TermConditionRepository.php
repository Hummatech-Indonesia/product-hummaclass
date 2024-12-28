<?php

namespace App\Contracts\Repositories\Configuration;

use App\Contracts\Interfaces\Configuration\TermConditionInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\TermCondition;

class TermConditionRepository  extends BaseRepository implements TermConditionInterface
{
    public function __construct(TermCondition $termCondition)
    {
        $this->model = $termCondition;
    }

    /**
     * Method show
     *
     * @return mixed
     */
    public function show(): mixed
    {
        return $this->model->firstOrFail();
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
        return $this->show()->update($data);
    }
}
