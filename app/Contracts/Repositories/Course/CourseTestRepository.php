<?php

namespace App\Contracts\Repositories\Course;

use App\Contracts\Interfaces\Course\CategoryInterface;
use App\Contracts\Interfaces\Course\CourseInterface;
use App\Contracts\Interfaces\Course\CourseTestInterface;
use App\Contracts\Interfaces\Course\ModuleQuestionInterface;
use App\Contracts\Interfaces\Course\QuizInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\Category;
use App\Models\Course;
use App\Models\CourseTest;
use App\Models\ModuleQuestion;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class CourseTestRepository extends BaseRepository implements CourseTestInterface
{
    /**
     * Method __construct
     *
     * @param Quiz $Quiz [explicite description]
     *
     * @return void
     */
    public function __construct(CourseTest $courseTest)
    {
        $this->model = $courseTest;
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
     * Method store
     *
     * @param array $data [explicite description]
     *
     * @return mixed
     */
    public function store(array $data): mixed
    {
        return $this->model->updateOrCreate(
            ['module_id' => $data['module_id']],
            $data
        );
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
        return $this->model->query()->where('module_id', $id)->firstOrFail();
    }
}
