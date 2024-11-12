<?php

namespace App\Contracts\Repositories\IndustryClass;

use App\Contracts\Interfaces\IndustryClass\StudentInterface;
use Illuminate\Http\Request;
use App\Models\StudentClassroom;
use App\Contracts\Repositories\BaseRepository;
use App\Models\Student;
use Illuminate\Pagination\LengthAwarePaginator;

class StudentRepository extends BaseRepository implements StudentInterface
{
    public function __construct(Student $student)
    {
        $this->model = $student;
    }
    public function getWhere(array $data): mixed
    {
        return $this->model->where($data)->get();
    }
    public function customPaginate(Request $request, int $pagination = 10): LengthAwarePaginator
    {
        return $this->model->fastPaginate($pagination);
    }
    public function get(): mixed
    {
        return $this->model->get();
    }
    public function store(array $data): mixed
    {
        return $this->model->create($data);
    }
    public function show(mixed $id): mixed
    {
        return $this->model->findOrFail($id);
    }
    public function update(mixed $id, array $data): mixed
    {
        return $this->show($id)->update($data);
    }
    public function delete(mixed $id): mixed
    {
        return $this->show($id)->delete();
    }
}
