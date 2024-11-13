<?php

namespace App\Helpers\Excel;

use App\Enums\RoleEnum;
use App\Models\Student;
use App\Models\StudentClassroom;
use App\Models\User;

class ImportStudentHelper
{
    /**
     * Handle import data event to models.
     *
     * @param array $data
     *
     * @return mixed
     */
    public static function import(array $data): mixed
    {
        $data['email_verified_at'] = now();
        $student = User::query()
            ->create($data);

        $student->student()->create($data);

        $student->assignRole(RoleEnum::STUDENT->value);

        $datas['data'] = $data;
        $datas['student'] = $student;
        return $datas;
    }
}
