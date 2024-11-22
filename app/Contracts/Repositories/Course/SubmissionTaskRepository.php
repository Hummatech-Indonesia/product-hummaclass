<?php

namespace App\Contracts\Repositories\Course;

use App\Contracts\Interfaces\Course\CategoryInterface;
use App\Contracts\Interfaces\Course\CourseInterface;
use App\Contracts\Interfaces\Course\CourseTaskInterface;
use App\Contracts\Interfaces\Course\SubmissionTaskInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\Category;
use App\Models\Course;
use App\Models\CourseTask;
use App\Models\SubmissionTask;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class SubmissionTaskRepository extends BaseRepository implements SubmissionTaskInterface
{
    /**
     * Method __construct
     *
     * @param SubmissionTask $submissionTask [explicite description]
     *
     * @return void
     */
    public function __construct(SubmissionTask $submissionTask)
    {
        $this->model = $submissionTask;
    }
    /**
     * Method getWhere
     *
     * @param array $data [explicite description]
     *
     * @return mixed
     */
    public function getWhere(array $data): mixed
    {
        return $this->model->query()->where($data)->get();
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
        if ($submissionTask = $this->model->query()->where('user_id', $data['user_id'])->where('module_task_id', $data['module_task_id'])->first()) {
            $updated = $this->model->query()->update($data);
            return $updated ? ['status' => "updated", 'data' => $submissionTask] : "failed";
        } else {
            $created = $this->model->query()->create($data);
            return $created ? ["status" => "created"] : "failed";
        }
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
