<?php

namespace App\Contracts\Repositories\Course;

use App\Contracts\Interfaces\Course\CategoryInterface;
use App\Contracts\Interfaces\Course\CourseInterface;
use App\Contracts\Interfaces\Course\ModuleQuestionInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\Category;
use App\Models\Course;
use App\Models\ModuleQuestion;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ModuleQuestionRepository extends BaseRepository implements ModuleQuestionInterface
{
    /**
     * Method __construct
     *
     * @param ModuleQuestion $ModuleQuestion [explicite description]
     *
     * @return void
     */
    public function __construct(ModuleQuestion $moduleQuestion)
    {
        $this->model = $moduleQuestion;
    }
    public function customPaginate(Request $request, int $pagination = 1): LengthAwarePaginator
    {
        return $this->model->query()->whereIn('id', $request->id)->fastPaginate($pagination);
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
     * getByModule
     *
     * @param  mixed $id
     * @return mixed
     */
    public function getByModule(string $id): mixed
    {
        return $this->model->query()->where('module_id', $id)->get();
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
