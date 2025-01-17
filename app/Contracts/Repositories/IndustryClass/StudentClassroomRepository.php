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
     * customPaginate
     *
     * @param  mixed $request
     * @param  mixed $pagination
     * @return LengthAwarePaginator
     */
    public function listStudentPaginate(Request $request, mixed $id, int $pagination = 10): LengthAwarePaginator
    {
        return $this->model->query()
        ->where('classroom_id', $id)
        ->when($request->search, function ($query) use ($request) {
            $query->whereRelation('student.user', 'name', 'like', '%' . strtolower($request->search) . '%')
                ->orWhereRelation('student.user', 'phone_number', 'like', '%' . strtolower($request->search) . '%')
                ->orWhereRelation('student.user', 'email', 'like', '%' . strtolower($request->search) . '%');
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

    /**
     * delete_all
     *
     * @param  mixed $classroom_id
     * @return mixed
     */
    public function delete_all(string $classroom_id): mixed
    {
        return $this->model->query()->where('classroom_id', $classroom_id)->delete();
    }
}
