<?php

namespace App\Contracts\Repositories\IndustryClass;

use App\Contracts\Interfaces\IndustryClass\StudentClassroomInterface;
use Illuminate\Http\Request;
use App\Models\StudentClassroom;
use App\Contracts\Repositories\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class StudentClassroomRepository extends BaseRepository implements StudentClassroomInterface
{

    public function __construct(StudentClassroom $model)
    {
        $this->model = $model;
    }

    /**
     * customPaginate
     *
     * @param  mixed $request
     * @param  mixed $pagination
     * @return LengthAwarePaginator
     */
    public function customPaginate(Request $request, int $pagination = 10): LengthAwarePaginator
    {
        return $this->model->query()->when($request->name, function ($query) use ($request) {
            $query->whereRelation('student.user', 'name', 'like', '%' . strtolower($request->name) . '%');
        })->when($request->classroom_id, function ($query) use ($request) {
            $query->where('classroom_id', $request->classroom_id);
        })->fastPaginate($pagination);
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
}
