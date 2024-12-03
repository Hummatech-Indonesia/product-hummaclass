<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LearningPathRequest extends ApiRequest
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
            'class_level' => 'required',
            'course_id' => 'required|array',
        ];
    }
    /**
     * Method messages
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'division_id.required' => 'divisi wajib diisi',
            'class_level.required' => 'kelas wajib diisi',
            'course_id.required' => 'kursus wajib diisi',
            'course_id.array' => 'kursus wajib berupa array'
        ];
    }

}
