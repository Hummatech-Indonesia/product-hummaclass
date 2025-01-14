<?php

namespace App\Http\Requests\IndustryClass;

use App\Http\Requests\ApiRequest;

class StudentClassroomRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'student_id' => 'required|array',
            'student_id.*' => 'exists:students,id'
        ];
    }

    /**
     * messages
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'student_id.required' => 'Siswa wajib diisi',
            'student_id.array' => 'Siswa wajib bertipe array',
            'student_id.*' => 'Id Siswa tidak sesuai'
        ];
    }
}
