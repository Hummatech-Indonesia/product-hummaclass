<?php

namespace App\Contracts\Repositories\IndustryClass;

use App\Contracts\Interfaces\IndustryClass\AssesmentFormStudentInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\AssesmentFormStudent;
use App\Models\AssessmentForm;
use App\Models\Student;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

use function Laravel\Prompts\search;

class AssesmentFormStudentRepository extends BaseRepository implements AssesmentFormStudentInterface
{
    protected $assesmentStudentForm;
    protected $student;
    public function __construct(AssessmentForm $assessmentForm, AssesmentFormStudent $assesmentStudentForm, Student $student)
    {
        $this->model = $assessmentForm;
        $this->assesmentStudentForm = $assesmentStudentForm;
        $this->student = $student;
    }

    /**
     * store
     *
     * @param  mixed $data
     * @return mixed
     */
    public function store(array $data): mixed
    {
        return $this->assesmentStudentForm->query()->create($data);
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

    public function getStudentAssesment(Request $request, mixed $classroomId, int $pagination = 10): LengthAwarePaginator
    {
        return $this->student->query()
            ->with(['user', 'assesmentFormStudents', 'studentClassrooms'])
            ->whereHas('studentClassrooms', function ($query) use ($classroomId) {
                $query->where('classroom_id', $classroomId);
            })
            ->when($request->search, function ($query) use ($request) {
                $query->whereRelation('user', 'name', 'LIKE', "%$request->search%");
            })
            ->fastPaginate($pagination);
    }
}
