<?php

namespace App\Contracts\Repositories\IndustryClass;

use App\Contracts\Interfaces\IndustryClass\ClassroomInterface;
use App\Contracts\Interfaces\IndustryClass\SchoolInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\Classroom;
use App\Models\School;
use FontLib\Table\Type\maxp;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ClassroomRepository extends BaseRepository implements ClassroomInterface
{
    public function __construct(Classroom $classroom)
    {
        $this->model = $classroom;
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

    public function search(mixed $query, Request $request): mixed
    {
        return $this->model->query()
            ->where('user_id', $query)
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('class_level', 'like', '%' . $request->search . '%')
                    ->orWhereRelation('teacher.user', 'name', 'like', '%' . $request->search . '%')
                    ->orWhereRelation('school', 'name', 'like', '%' . $request->search . '%');
            })
            ->get();
    }

    public function take(mixed $query, mixed $count): mixed
    {
        return $this->model->query()->where($query)->take($count)->get();
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

    public function showWithSlug(string $slug): mixed
    {
        return $this->model->query()->where('slug', $slug)->first();
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

    public function customPaginate(Request $request, mixed $query, int $pagination = 9): LengthAwarePaginator
    {
        return $this->model->query()
            ->where($query)
            ->when($request->search, function($query) use ($request){
                $query->where('name', 'LIKE', '%' . $request->search .'%');
            })->when($request->school, function($query) use ($request){
                $query->where('school_id', 'LIKE', '%'. $request->school . '%');
            })->when($request->classroom, function($query) use ($request){
                $query->where('classroom_id', 'LIKE', '%'. $request->classroom . '%');
            })->fastPaginate($pagination);
    }
}
