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
        $user = User::query()
            ->create($data);

        $student = $user->student()->create($data);

        $user->assignRole(RoleEnum::STUDENT->value);

        if ($data['classroom_id'] != null) {
            $student->studentClassrooms()->create($data);
        }

        return $data;
    }
}
