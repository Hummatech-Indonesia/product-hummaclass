<?php

namespace App\Contracts\Repositories\IndustryClass;

use App\Contracts\Interfaces\IndustryClass\SchoolYearInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Enums\SchoolYearStatusEnum;
use App\Models\SchoolYear;

class SchoolYearRepository extends BaseRepository implements SchoolYearInterface
{
    public function __construct(SchoolYear $schoolYear)
    {
        $this->model = $schoolYear;
    }

    /**
     * get
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
     * @return mixed
     */
    public function store(): mixed
    {

        try {
            $current = $this->model->query()->latest()->firstOrFail();
            $schoolYear = explode('/', $current->school_year);
            $newSchoolYear = intval($schoolYear[1]) . '/' . intval($schoolYear[1] + 1);
        } catch (\Throwable $e) {
            $currentYear = now()->year;
            $currentYearInc = $currentYear + 1;
            $schoolYear = $currentYear . '/' . $currentYearInc;
            return $this->model->query()->create([
                'school_year' => $schoolYear,
            ]);
        }
        return $this->model->query()->create(['school_year' => $newSchoolYear, 'status' => SchoolYearStatusEnum::ACTIVE->value]);
    }




    /**
     * Method delete
     *
     * @return mixed
     */
    public function delete(): mixed
    {
        $modelCount = $this->model->count();
        if ($modelCount > 1) {
            return $this->model->query()->latest()->firstOrFail()->delete();
        } else {
            return false;
        }
    }

    /**
     * getLatest
     *
     * @return mixed
     */
    public function getLatest(): mixed
    {
        return $this->model->query()->latest()->firstOrFail();
    }
}
