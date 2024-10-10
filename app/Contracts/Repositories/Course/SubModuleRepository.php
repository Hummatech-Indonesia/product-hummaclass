<?php

namespace App\Contracts\Repositories\Course;

use App\Contracts\Interfaces\Course\SubModuleInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\Module;
use App\Models\SubModule;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

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
     * Method customPaginate
     *
     * @param Request $request [explicite description]
     * @param int $pagination [explicite description]
     *
     * @return LengthAwarePaginator
     */
    public function customPaginate(Request $request, int $pagination = 10): LengthAwarePaginator
    {
        return $this->model->query()
            ->when($request->search, function ($query) use ($request) {
                $query->whereLike('title', $request->search);
            })->when($request->module_id, function ($query) use ($request) {
                $query->where('module_id', $request->module_id);
            })
            ->fastPaginate($pagination);
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

    /**
     * getOneByModul
     *
     * @param  mixed $id
     * @return mixed
     */
    public function getOneByModul(string $id): mixed
    {
        return $this->model->query()
            ->where('module_id', $id)
            ->latest()
            ->first();
    }

    /**
     * showWithSlug
     *
     * @param  mixed $slug
     * @return mixed
     */
    public function showWithSlug(string $slug): mixed
    {
        return $this->model->query()
            ->where('slug', $slug)->firstOrFail();
    }

    /**
     * nextSubModule
     *
     * @return mixed
     */
    public function nextSubModule(mixed $step, mixed $module_id): mixed
    {
        return $this->model->query()->where('module_id', $module_id)->where('step', $step + 1)->first();
    }
    /**
     * Method prevSubModule
     *
     * @param mixed $step [explicite description]
     * @param mixed $module_id [explicite description]
     *
     * @return mixed
     */
    public function prevSubModule(mixed $step, mixed $module_id): mixed
    {
        return $this->model->query()->where('module_id', $module_id)->where('step', $step - 1)->first();
    }
    public function getAllPrevSubModule(mixed $step, mixed $module_id): mixed
    {
        return $this->model->query()->get();
    }
}
