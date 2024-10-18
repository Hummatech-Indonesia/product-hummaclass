<?php

namespace App\Contracts\Repositories\Course;

use App\Contracts\Interfaces\Course\CategoryInterface;
use App\Contracts\Interfaces\Course\CourseInterface;
use App\Contracts\Interfaces\Course\UserCourseInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\Category;
use App\Models\Course;
use App\Models\UserCourse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class UserCourseRepository extends BaseRepository implements UserCourseInterface
{
    public function __construct(UserCourse $userCourse)
    {
        $this->model = $userCourse;
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
        return $this->model->query()->where('course_id', $request->course_id)->fastPaginate($pagination);
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
     * delete
     *
     * @param  mixed $id
     * @return mixed
     */
    public function delete(mixed $id): mixed
    {
        return $this->model->show($id)->delete();
    }
    /**
     * show
     *
     * @param  mixed $id
     * @return mixed
     */
    public function show(mixed $id): mixed
    {
        return $this->model->query()->findOrFail($id);
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
        return $this->model->query()->where('user_id', auth()->user()->id)->where('course_id', $id)->firstOrFail()->update($data);
    }
    /**
     * Method showByUserCourse
     *
     * @param $courseId $courseId [explicite description]
     *
     * @return mixed
     */
    public function showByUserCourse($courseId): mixed
    {
        return $this->model->query()->where('user_id', auth()->user()->id)->where('course_id', $courseId)->with('subModule')->firstOrFail();
    }
}
