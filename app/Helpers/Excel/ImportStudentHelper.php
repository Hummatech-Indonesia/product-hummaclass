<?php

namespace App\Helpers\Excel;

use App\Enums\RoleEnum;
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
        $student = User::query()
            ->create($data);

        $student->student()->create($data);

        $student->assignRole(RoleEnum::STUDENT->value);

        return $student;
    }
}
