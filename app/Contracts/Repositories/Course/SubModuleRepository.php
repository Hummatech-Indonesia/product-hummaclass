<?php

namespace App\Contracts\Repositories\Course;

use App\Contracts\Interfaces\Course\SubModuleInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\Module;
use App\Models\SubModule;

class SubModuleRepository extends BaseRepository implements SubModuleInterface
{
    
    /**
     * Method __construct
     *
     * @param SubModule $subModule [explicite description]
     *
     * @return void
     */
    public function __construct(SubModule $subModule)
    {
        $this->model = $subModule;
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