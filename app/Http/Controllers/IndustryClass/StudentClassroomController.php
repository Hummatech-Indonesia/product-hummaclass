<?php

namespace App\Http\Controllers\IndustryClass;

use App\Contracts\Interfaces\IndustryClass\ClassroomInterface;
use App\Contracts\Interfaces\IndustryClass\StudentClassroomInterface;
use App\Contracts\Interfaces\IndustryClass\StudentInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\IndustryClass\StudentClassroomRequest;
use App\Http\Resources\IndustryClass\StudentClassroomResource;
use App\Models\Classroom;
use App\Traits\PaginationTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StudentClassroomController extends Controller
{
    use PaginationTrait;
    private StudentClassroomInterface $studentClassroom;
    private StudentInterface $student;

    public function __construct(StudentClassroomInterface $studentClassroom, StudentInterface $student)
    {
        $this->studentClassroom = $studentClassroom;
        $this->student = $student;
    }

    /**
     * index
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function byClassroom(Request $request, Classroom $classroom): JsonResponse
    {
        $request->merge(['classroom_id' => $classroom->id]);
        $studentClassrooms = $this->studentClassroom->customPaginate($request);
        $data['paginate'] = $this->customPaginate($studentClassrooms->currentPage(), $studentClassrooms->lastPage());
        $data['data'] = StudentClassroomResource::collection($studentClassrooms);
        return ResponseHelper::success($data);
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function store(StudentClassroomRequest $request, Classroom $classroom): JsonResponse
    {
        $this->studentClassroom->delete_all($classroom->id);
        foreach ($request->student_id as $student_id) {
            $this->studentClassroom->store(['classroom_id' => $classroom->id, 'student_id' => $student_id]);
        }
        return ResponseHelper::success();
    }

    public function listStudent(Request $request)
    {
        try {
            $student = $this->student->first(['user_id' => auth()->user()->id]);
            if ($request->has('page')) {
                $students = $this->studentClassroom->listStudentPaginate($request, $student->studentClassrooms()->latest()->first()->classroom->id);
                $data['paginate'] = $this->customPaginate($students->currentPage(), $students->lastPage());
                $data['data'] = StudentClassroomResource::collection($students);
            } else {
                $students = $this->studentClassroom->listStudentPaginate($request, $student->studentClassrooms()->latest()->first()->classroom->id);
                $data['data'] = StudentClassroomResource::collection($students);
            }
            return ResponseHelper::success($data, trans('alert.fetch_success'));
        } catch (\Throwable $th) {
            return ResponseHelper::success(null, trans('alert.fetch_failed'));
        }
    }
}
