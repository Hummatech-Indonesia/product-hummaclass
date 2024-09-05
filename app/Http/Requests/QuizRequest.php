<?php

namespace App\Http\Requests;

use App\Models\ModuleQuestion;
use Illuminate\Foundation\Http\FormRequest;

class QuizRequest extends ApiRequest
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
            'title' => 'required',
            'total_question' => [
                'required',
                'integer',
                function ($attribute, $value, $fail) {
                    $moduleQuestionCount = ModuleQuestion::count();
                    if ($value > $moduleQuestionCount) {
                        $fail("Jumlah pertanyaan tidak boleh lebih dari {$moduleQuestionCount}");
                    }
                }
            ]
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
            'title.required' => 'Judul wajib diisi',
            'total_question.required' => 'Total pertanyaan wajib diisi',
            'total_question.integer' => 'Total pertanyaan wajib berupa angka'
        ];
    }
}
