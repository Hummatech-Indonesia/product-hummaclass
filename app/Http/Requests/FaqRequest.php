<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FaqRequest extends ApiRequest
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
            'question' => 'nullable|string|max:255',
            'answer' => 'nullable'
        ];
    }
    public function messages(): array
    {
        return [
            'question.required' => 'Pertanyaan wajib diisi',
            'question.max' => 'Pertanyaan maksimal :max karater',
            'answer.required' => 'Jawaban wajib diisi',
        ];
    }
}
