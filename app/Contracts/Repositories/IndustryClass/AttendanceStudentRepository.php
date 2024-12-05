<?php

namespace App\Contracts\Repositories\IndustryClass;

use App\Contracts\Interfaces\IndustryClass\AttendanceStudentInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\AttendanceStudent;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

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

    public function getWhere(array $data): mixed
    {
        return $this->model->query()->where('attendance_id', $data['attendance_id'])->get();
    }

    public function customPaginate(Request $request, mixed $query, int $pagination = 10): LengthAwarePaginator
    {
        return $this->model->query()
            ->where('attendance_id', $query)
            ->when($request->search, function($query) use ($request){
                $query->whereRelation('student.user', 'name', 'Like', '%' . $request->search . '%' );
            })->fastPaginate($pagination);
    }
}
