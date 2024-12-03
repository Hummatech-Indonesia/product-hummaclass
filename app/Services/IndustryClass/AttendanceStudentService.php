<?php

namespace App\Services\IndustryClass;

use App\Models\Attendance;
use App\Models\Student;

use function Laravel\Prompts\error;

class AttendanceStudentService
{
    /**
     * store
     *
     * @param  mixed $request
     * @return array
     */
    public function store(Attendance $attendance): array|bool
    {
        $student = Student::where('user_id', auth()->user()->id)->first();
        if ($attendance->classroom_id == $student->studentClassrooms()->latest()->first()->classroom_id) {
            $data['student_id'] = $student->id;
            $data['attendance_id'] = $attendance->id;
            return $data;
        }

        return false;
    }
}
