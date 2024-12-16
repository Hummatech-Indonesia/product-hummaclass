<?php

namespace App\Contracts\Repositories\IndustryClass;

use App\Contracts\Interfaces\IndustryClass\AssesmentFormInterface;
use Illuminate\Http\Request;
use App\Contracts\Repositories\BaseRepository;
use App\Models\AssessmentForm;
use Illuminate\Pagination\LengthAwarePaginator;

class AssesmentFormRepository extends BaseRepository implements AssesmentFormInterface
{
    public function __construct(AssesmentFormInterface $assessmentForm)
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
        return $this->model->query()->where('class_level', $data['class_level'])->where('division_id', $data['division_id'])->where('type', $data['type'])->get();
    }

    /**
     * deleteWhere
     *
     * @param  mixed $data
     * @return mixed
     */
    public function deleteWhere(array $data): mixed
    {
        return $this->model->query()->where('class_level', $data['class_level'])->where('division_id', $data['division_id'])->where('type', $data['type'])->delete();
    }
}
