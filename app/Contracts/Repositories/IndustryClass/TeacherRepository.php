<?php

namespace App\Contracts\Repositories\IndustryClass;

use App\Contracts\Interfaces\IndustryClass\TeacherInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class TeacherRepository extends BaseRepository implements TeacherInterface
{
    public function __construct(Teacher $teacher)
    {
        $this->model = $teacher;
    }
    public function customPaginate(Request $request, int $pagination = 8): LengthAwarePaginator
    {
        return $this->model->query()
            ->where(['school_id' => $request->school_id])
            ->with('user') // Load relationship
            ->when($request->search, function ($query) use ($request) {
                return $query->whereHas('user', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->search . '%');
                });
            })
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
