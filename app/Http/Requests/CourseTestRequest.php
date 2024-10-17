<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseTestRequest extends FormRequest
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
            'total_question' => 'required',
            'duration' => 'required',
            'is_submitted' => 'required|boolean'
        ];
    }

    public function messages(): array
    {
        return [
            'total_question.required' => 'Total Pertanyaan Wajib Diisi',
            'duration.required' => 'Durasi Wajib Wajib Diisi',
            'total_question.required' => 'Total Pertanyaan Wajib Diisi',
        ];
    }
}
