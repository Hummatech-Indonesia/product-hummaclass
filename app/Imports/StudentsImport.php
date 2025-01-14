<?php

namespace App\Imports;

use App\Helpers\Excel\ImportStudentHelper;
use App\Models\Classroom;
use Carbon\Carbon;
use App\Models\School;
use App\Models\StudentClassroom;
use App\Models\User;
use App\Traits\Excel\ValidationStudentTrait;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class StudentsImport implements ToModel, WithHeadingRow, WithValidation
{
    use ValidationStudentTrait;

    protected $school_id;

    public function __construct(mixed $school_id)
    {
        $this->school_id = $school_id;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $classroom = isset($row['kelas'])
            ? Classroom::query()->where('school_id', $this->school_id)->where('name', $row['kelas'])->first()
            : null;

        $gender = strtolower($row['jenis_kelamin']);

        $date_birth = !empty($row['tanggal_lahir'])
            ? Carbon::createFromFormat('Y-m-d', '1900-01-01')->addDays($row['tanggal_lahir'] - 2)->format('Y-m-d')
            : null;

        // DB::beginTransaction();
        // try {
        ImportStudentHelper::import([
            'name' => $row['nama'],
            'email' => $row['email'],
            'phone_number' => $row['no_hp'],
            'address' => $row['alamat'],
            'gender' => $gender,
            'nisn' => $row['nisn'],
            'date_birth' => $date_birth,
            'school_id' => $this->school_id,
            'classroom_id' => $classroom->id ?? null
        ]);

        // DB::commit();
        // } catch (\Throwable $th) {
        //     DB::rollBack();
        //     throw new \Exception("Error Processing Request", 0, $th);
        // }
    }
}
