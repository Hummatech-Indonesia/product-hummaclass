<?php

namespace App\Imports;

use App\Helpers\Excel\ImportStudentHelper;
use App\Models\User;
use App\Traits\Excel\ValidationStudentTrait;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class StudentsImport implements ToModel, WithHeadingRow, WithValidation
{
    use ValidationStudentTrait;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (strtolower($row['jenis_kelamin']) == "laki-laki" || strtolower($row['jenis_kelamin']) == "male") {
            $gender = "male";
        } else {
            $gender = "female";
        }

        ImportStudentHelper::import([
            'name' => $row['nama'],
            'email' => $row['email'],
            'phone_number' => $row['no_hp'],
            'address' => $row['alamat'],
            'gender' => $gender
        ]);
    }
}
