<?php

namespace App\Contracts\Repositories\Course;

use App\Contracts\Interfaces\Course\CategoryInterface;
use App\Contracts\Interfaces\Course\CourseInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class CourseRepository extends BaseRepository implements CourseInterface
{
    /**
     * Method __construct
     *
     * @param Course $course [explicite description]
     *
     * @return void
     */
    public function __construct(Course $course)
    {
        $this->model = $course;
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
        return $this->model->query()->with('modules')->when($request->search, function ($query) use ($request) {
            $query->whereLike('name', $request->search);
        })->fastPaginate($pagination);
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