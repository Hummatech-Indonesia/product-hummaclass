<?php

namespace App\Contracts\Repositories\IndustryClass;

use App\Contracts\Interfaces\IndustryClass\AttendanceStudentInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\AttendanceStudent;

class AttendanceStudentRepository extends BaseRepository implements AttendanceStudentInterface
{
    public function __construct(AttendanceStudent $attendanceStudent)
    {
        $this->model = $attendanceStudent;
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
}
