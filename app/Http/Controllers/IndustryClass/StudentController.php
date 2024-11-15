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
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
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
    public function index(string $slug)
    {
        $school = $this->school->showWithSlug($slug);
        $students = $this->student->getWhere(['school_id' => $school->id]);
        return ResponseHelper::success(StudentResource::collection($students), trans('alert.fetch_success'));
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
    public function store(UserStudentRequest $request, School $school): JsonResponse
    {
        $userData = $request->validated();
        $user = $this->user->store($userData);
        $user->assignRole(RoleEnum::STUDENT->value);

        $studentData['school_id'] = $school->id;
        $studentData['user_id'] = $user->id;
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
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StudentRequest $request, Student $student)
    {
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
}
