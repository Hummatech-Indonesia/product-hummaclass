<?php

namespace App\Http\Controllers\IndustryClass;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use StudentInterface;

class StudentController extends Controller
{
    private StudentInterface $student;
    public function __construct(StudentInterface $student) {
        $this->student = $student;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request, $schoolId)
    {
        $data = $request->validated();
        try {
            if($this->student->store($schoolId, $data)) {
                return ResponseHelper::success(null, trans('alert.add_success'));
            };
        } catch (\Throwable $th) {
            return ResponseHelper::error(null, trans('alert.add_failed'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
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
    public function update(Request $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        //
    }
}
