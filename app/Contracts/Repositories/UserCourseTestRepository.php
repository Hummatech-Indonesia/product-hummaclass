<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\BlogInterface;
use App\Contracts\Interfaces\EventDetailInterface;
use App\Contracts\Interfaces\EventInterface;
use App\Contracts\Interfaces\RegisterInterface;
use App\Contracts\Interfaces\UserCourseTestInterface;
use App\Contracts\Interfaces\UserInterface;
use App\Contracts\Interfaces\UserQuizInterface;
use App\Enums\UserRoleEnum;
use App\Helpers\UserHelper;
use App\Models\Blog;
use App\Models\Event;
use App\Models\EventDetail;
use App\Models\User;
use App\Models\UserCourseTest;
use App\Models\UserQuiz;
use App\Traits\Datatables\UserDatatable;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class UserCourseTestRepository extends BaseRepository implements UserCourseTestInterface
{
    public function __construct(UserCourseTest $userCourseTest)
    {
        $this->model = $userCourseTest;
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
     * customPaginate
     *
     * @param  mixed $request
     * @param  mixed $pagination
     * @return LengthAwarePaginator
     */
    public function customPaginate(Request $request, int $pagination = 10): LengthAwarePaginator
    {
        return $this->model->newQuery()
            ->with('courseTest')
            ->when($request->quiz_id, function ($query) use ($request) {
                $query->where('quiz_id', $request->quiz_id);
            })
            ->when($request->course_id, function ($query) use ($request) {
                $query->whereHas('courseTest', function ($query) use ($request) {
                    $query->where('course_id', $request->course_id);
                });
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
        return $this->model->query()->findOrFail($id)->update($data);
    }

    public function getByClassroom(mixed $data): mixed
    {
        return $this->model->query()
            ->whereNotNull('score')
            ->whereHas('user', function ($query) use ($data) {
                $query->whereHas('student', function ($query) use ($data) {
                    $query->whereHas('studentClassrooms', function ($query) use ($data) {
                        $query->where('classroom_id', $data);
                    });
                });
            });
    }
}
