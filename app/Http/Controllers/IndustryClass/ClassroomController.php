<?php

namespace App\Http\Controllers\IndustryClass;

use App\Contracts\Interfaces\IndustryClass\ClassroomInterface;
use App\Contracts\Interfaces\IndustryClass\SchoolInterface;
use App\Contracts\Interfaces\IndustryClass\StudentClassroomInterface;
use App\Contracts\Interfaces\IndustryClass\StudentInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\IndustryClass\ClassroomRequest;
use App\Http\Requests\IndustryClass\MentorClassroomRequest;
use App\Http\Requests\IndustryClass\TeacherClassroomRequest;
use App\Http\Resources\IndustryClass\ClassroomResource;
use App\Http\Resources\IndustryClass\StudentClassroomResource;
use App\Models\Classroom;
use App\Models\School;
use App\Models\User;
use App\Traits\PaginationTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    use PaginationTrait;
    private ClassroomInterface $classroom;
    private SchoolInterface $school;
    private StudentInterface $student;
    private StudentClassroomInterface $studentClassroom;

    public function __construct(ClassroomInterface $classroom, SchoolInterface $school, StudentInterface $student, StudentClassroomInterface $studentClassroom)
    {
        $this->classroom = $classroom;
        $this->school = $school;
        $this->student = $student;
        $this->studentClassroom = $studentClassroom;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(string $slug)
    {
        $school = $this->school->showWithSlug($slug);
        $classrooms = $this->classroom->getWhere(['school_id' => $school->id]);
        return ResponseHelper::success(ClassroomResource::collection($classrooms));
    }

    public function getAll(): JsonResponse
    {
        $classrooms = $this->classroom->get();
        return ResponseHelper::success(ClassroomResource::collection($classrooms), trans('alert.fetch_success'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClassroomRequest $request, string $slug)
    {
        $school = $this->school->showWithSlug($slug);
        $data = $request->validated();
        $data['school_id'] = $school->id;
        $this->classroom->store($data);
        return ResponseHelper::success(null, trans('alert.add_success'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Classroom $classroom)
    {
        return ResponseHelper::success(ClassroomResource::make($classroom), trans('alert.fetch_success'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClassroomRequest $request, Classroom $classroom)
    {
        $this->classroom->update($classroom->id, $request->validated());
        return ResponseHelper::success(null, trans('alert.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classroom $classroom): JsonResponse
    {
        try {
            $this->classroom->delete($classroom->id);
        } catch (\Throwable $e) {
            return ResponseHelper::error(null, trans('alert.delete_constrained'));
        }
        return ResponseHelper::success(null, trans('alert.delete_success'));
    }

    /**
     * teacherClassroom
     *
     * @param  mixed $classroom
     * @param  mixed $teacherClassroomRequest
     * @return JsonResponse
     */
    public function teacherClassroom(Classroom $classroom, TeacherClassroomRequest $teacherClassroomRequest): JsonResponse
    {
        $this->classroom->update($classroom->id, $teacherClassroomRequest->validated());
        return ResponseHelper::success(null, trans('alert.add_success'));
    }

    /**
     * mentorClassroom
     *
     * @param  mixed $user
     * @param  mixed $request
     * @return JsonResponse
     */
    public function mentorClassroom(Classroom $classroom, MentorClassroomRequest $mentorClassroomRequest): JsonResponse
    {
        $this->classroom->update($classroom->id, $mentorClassroomRequest->validated());
        return ResponseHelper::success(null, 'Berhasil menambahkan mentor');
    }

    /**
     * mentorClassroom
     *
     * @param  mixed $user
     * @param  mixed $request
     * @return JsonResponse
     */
    public function listClassroom(Request $request): JsonResponse
    {
        $classrooms = $this->classroom->search(auth()->user()->id, $request);
        return ResponseHelper::success(ClassroomResource::collection($classrooms), trans('alert.fetch_success'));
    }

    /**
     * mentorClassroom
     *
     * @param  mixed $user
     * @param  mixed $request
     * @return JsonResponse
     */
    public function listClassroomDashboard(): JsonResponse
    {
        $classrooms = $this->classroom->take(['user_id' => auth()->user()->id], 8);
        return ResponseHelper::success(ClassroomResource::collection($classrooms), trans('alert.fetch_success'));
    }

    /**
     * mentorClassroom
     *
     * @param  mixed $user
     * @param  mixed $request
     * @return JsonResponse
     */
    public function showDetailClassroom(Request $request, string $slug): JsonResponse
    {
        $classroom = $this->classroom->showWithSlug($slug);
        return ResponseHelper::success(ClassroomResource::make($classroom), trans('alert.fetch_success'));
    }

    /**
     * mentorClassroom
     *
     * @param  mixed $user
     * @param  mixed $request
     * @return JsonResponse
     */
    public function showDetailStudent(Request $request): JsonResponse
    {
        if ($request->has('page')) {
            $students = $this->studentClassroom->customPaginate($request);
            $data['paginate'] = $this->customPaginate($students->currentPage(), $students->lastPage());
            $data['data'] = StudentClassroomResource::collection($students);
        } else {
            $students = $this->studentClassroom->customPaginate($request);
            $data['data'] = StudentClassroomResource::collection($students);
        }
        return ResponseHelper::success($data, trans('alert.fetch_success'));
    }

    
}
