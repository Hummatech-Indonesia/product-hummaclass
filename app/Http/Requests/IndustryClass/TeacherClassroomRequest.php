<?php

namespace App\Http\Requests\IndustryClass;

use App\Http\Requests\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class TeacherClassroomRequest extends ApiRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'teacher_id' => 'required|exists:teachers,id'
        ];
    }

    public function messages(): array
    {
        return [
            'teacher_id.required' => 'Guru wajib diisi',
            'teacher_id.exists' => 'Id Guru tidak sesuai'
        ];
    }
}
