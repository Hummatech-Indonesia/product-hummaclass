<?php

namespace App\Contracts\Repositories\IndustryClass;

use App\Contracts\Interfaces\IndustryClass\AssesmentFormStudentInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\AssessmentForm;

class AssesmentFormStudentRepository extends BaseRepository implements AssesmentFormStudentInterface
{
    public function __construct(AssesmentFormStudentRepository $assessmentForm)
    {
        $this->model = $assessmentForm;
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
     * getWhere
     *
     * @param  mixed $data
     * @return mixed
     */
    public function getWhere(array $data): mixed
    {
        return $this->model->query()->where('student_id', $data['student_id'])->get();
    }
}
