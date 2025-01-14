<?php

namespace App\Http\Requests\IndustryClass;

use App\Http\Requests\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class ClassroomRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'division_id' => 'required',
            'name' => 'required',
            'class_level' => 'required',
            'school_year_id' => 'required|exists:school_years,id'
        ];
    }

    public function messages(): array
    {
        return [
            'division_id.required' => 'Divisi harus diisi.',
            'name.required' => 'Nama harus diisi.',
            'class_level.required' => 'Tingkat kelas harus diisi.',
            'school_year_id.required' => 'Tahun ajaran harus diisi.',
            'school_year_id.exists' => 'Tahun ajaran yang dipilih tidak valid.'
        ];
    }
}
