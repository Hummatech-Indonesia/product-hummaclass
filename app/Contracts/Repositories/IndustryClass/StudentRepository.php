<?php

namespace App\Contracts\Repositories\IndustryClass;

use App\Contracts\Interfaces\IndustryClass\StudentInterface;
use Illuminate\Http\Request;
use App\Models\StudentClassroom;
use App\Contracts\Repositories\BaseRepository;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class StudentRepository extends BaseRepository implements StudentInterface
{
    public Model $tb_user;

    public function __construct(Student $student, User $user)
    {
        $this->model = $student;
        $this->tb_user = $user;
    }

    /**
     * getWhere
     *
     * @param  mixed $data
     * @return mixed
     */
    public function getWhere(array $data): mixed
    {
        return $this->model->where($data)->get();
    }

    /**
     * getWhere
     *
     * @param  mixed $data
     * @return mixed
     */
    public function first(mixed $query): mixed
    {
        return $this->model->where($query)->first();
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
        return $this->model->when($request->school_id, function ($query) use ($request) {
            $query->where('school_id', $request->school_id);
        })->when($request->name, function ($query) use ($request) {
            $query->whereRelation('user', 'name', 'LIKE', '%' . $request->name . '%');
        })->fastPaginate($pagination);
    }

    public function userPoint(): mixed
    {
        return $this->tb_user->select('point')->whereColumn('users.id', 'students.user_id')->limit(1);
    }

    public function listRangePoint(Request $request, int $pagination = 10): LengthAwarePaginator    
    {
        return $this->model->when($request->school_id, function ($query) use ($request) {
            $query->where('school_id', $request->school_id);
        })->when($request->classroom_id, function($query) use ($request) {
            $query->whereRelation('studentClassrooms.classroom', 'id' , $request->classroom_id);
        })->when($request->name, function ($query) use ($request) {
            $query->whereRelation('user', 'name', 'LIKE', '%' . $request->name . '%');
        })
        ->with('user')
        ->orderByDesc(
            $this->userPoint()
        )
        ->fastPaginate($pagination);
    }

    /**
     * get
     *
     * @return mixed
     */
    public function get(): mixed
    {
        return $this->model->get();
    }

    /**
     * store
     *
     * @param  mixed $data
     * @return mixed
     */
    public function store(array $data): mixed
    {
        return $this->model->create($data);
    }

    /**
     * show
     *
     * @param  mixed $id
     * @return mixed
     */
    public function show(mixed $id): mixed
    {
        return $this->model->findOrFail($id);
    }

    /**
     * update
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return mixed
     */
    public function update(mixed $id, array $data): mixed
    {
        return $this->show($id)->update($data);
    }

    /**
     * delete
     *
     * @param  mixed $id
     * @return mixed
     */
    public function delete(mixed $id): mixed
    {
        return $this->show($id)->delete();
    }

    /**
     * getWithout
     *
     * @return mixed
     */
    public function getWithout(string $school_id): mixed
    {
        return $this->model->query()->where('school_id', $school_id)->get();
    }
}
