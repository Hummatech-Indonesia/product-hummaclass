<?php

namespace App\Http\Controllers\IndustryClass;

use App\Contracts\Interfaces\Auth\UserInterface;
use App\Contracts\Interfaces\IndustryClass\SchoolInterface;
use App\Contracts\Interfaces\IndustryClass\StudentInterface;
use App\Enums\RoleEnum;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ImportRequest;
use App\Http\Requests\StudentRequest;
use App\Http\Requests\UserStudentRequest;
use App\Http\Resources\StudentResource;
use App\Imports\StudentsImport;
use App\Models\School;
use App\Models\Student;
use App\Traits\PaginationTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    use PaginationTrait;
    private StudentInterface $student;
    private SchoolInterface $school;
    private UserInterface $user;
    public function __construct(StudentInterface $student, SchoolInterface $school, UserInterface $user)
    {
        $this->student = $student;
        $this->school = $school;
        $this->user = $user;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, string $slug)
    {
        $school = $this->school->showWithSlug($slug);
        $request->merge(['school_id' => $school->id]);
        $students = $this->student->customPaginate($request);
        $data['paginate'] = $this->customPaginate($students->currentPage(), $students->lastPage());
        $data['data'] = StudentResource::collection($students);
        return ResponseHelper::success($data, trans('alert.fetch_success'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStudentRequest $request, string $slug): JsonResponse
    {
        $school = $this->school->showWithSlug($slug);
        $userData = $request->validated();
        $userData['password'] = bcrypt('password');
        $user = $this->user->store($userData);
        $user->assignRole(RoleEnum::STUDENT->value);

        $studentData['school_id'] = $school->id;
        $studentData['user_id'] = $user->id;
        $studentData['nisn'] = $userData['nisn'];
        $studentData['date_birth'] = $userData['date_birth'];
        $student = $this->student->store($studentData);
        if (!$student) {
            $this->user->delete($user->id);
        }
        return ResponseHelper::success(null, trans('alert.add_success'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        return ResponseHelper::success(StudentResource::make($student), trans('alert.fetch_success'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UserStudentRequest $request, Student $student)
    {
        $this->user->customUpdate($student->user->id, $request->validated());
        $this->student->update($student->id, $request->validated());
        return ResponseHelper::success(null, trans('alert.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        try {
            $user = $student->user;
            $this->user->delete($user->id);
        } catch (\Throwable $e) {
            return ResponseHelper::error(null, trans('alert.delete_constrained'));
        }
        return ResponseHelper::success(null, trans('alert.delete_success'));
    }

    /**
     * import
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function import(ImportRequest $request, string $slug): JsonResponse
    {
        $school = $this->school->showWithSlug($slug);
        Excel::import(new StudentsImport($school->id), $request->file('file'));
        return ResponseHelper::success(null, trans('alert.add_success'));
    }

    /**
     * withoutClassroom
     *
     * @return JsonResponse
     */
    public function withoutClassroom(string $slugSchool): JsonResponse
    {
        $school = $this->school->showWithSlug($slugSchool);
        $students = $this->student->getWithout($school->id);
        return ResponseHelper::success(StudentResource::collection($students));
    }
}
