<?php

namespace App\Http\Requests\IndustryClass;

use Illuminate\Foundation\Http\FormRequest;

class AssesmentFormStudentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'assessment_form_id' => 'required|array',
            'assessment_form_id.*' => 'required||exists:assessment_forms,id',
            'value' => 'required|array',
            'value.*' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'assessment_form_id.required' => 'Formulir penilaian wajib dipilih.',
            'assessment_form_id.array' => 'Formulir penilaian harus berupa array.',
            'assessment_form_id.*.required' => 'Setiap formulir penilaian harus dipilih.',
            'assessment_form_id.*.exists' => 'Formulir penilaian yang dipilih tidak valid.',
            'value.required' => 'Nilai wajib diisi.',
            'value.array' => 'Nilai harus berupa array.',
            'value.*.required' => 'Setiap nilai harus diisi.',
        ];
    }
}
