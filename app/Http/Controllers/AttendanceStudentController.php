<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\IndustryClass\AttendanceStudentInterface;
use App\Helpers\ResponseHelper;
use App\Models\Attendance;
use App\Models\AttendanceStudent;
use App\Services\IndustryClass\AttendanceStudentService;
use Illuminate\Http\Request;

class AttendanceStudentController extends Controller
{
    private AttendanceStudentInterface $attendanceStudent;
    private AttendanceStudentService $service;

    public function __construct(AttendanceStudentInterface $attendanceStudent, AttendanceStudentService $service)
    {
        $this->attendanceStudent = $attendanceStudent;
        $this->service = $service;
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
    public function store(Attendance $attendance)
    {
        try {
            $data = $this->service->store($attendance);
            if (!$data) {
                return ResponseHelper::success(null, 'Kelas Anda Tidak Sesuai');
            }
            $this->attendanceStudent->store($data);
            return ResponseHelper::success(null, 'Berhasil Absensi');
        } catch (\Throwable $th) {
            return ResponseHelper::error(null, 'Gagal Absensi');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(AttendanceStudent $attendanceStudent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AttendanceStudent $attendanceStudent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AttendanceStudent $attendanceStudent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AttendanceStudent $attendanceStudent)
    {
        //
    }
}
