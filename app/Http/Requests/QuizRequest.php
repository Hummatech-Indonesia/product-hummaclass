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
            'duration' => 'required',
            'rules' => 'required',
            'minimum_score' => 'required',
            'retry_delay' => 'required',
            'total_question' => [
                'required',
                'integer',
            ],
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
            'duration.required' => 'Durasi wajib diisi',
            'rules.required' => 'Peraturan wajib diisi',
            'total_question.required' => 'Total pertanyaan wajib diisi',
            'total_question.integer' => 'Total pertanyaan wajib berupa angka',
            'minimum_score.required' => 'Nilai minimal wajib diisi',
            'retry_delay.required' => 'Waktu tunggu remidial harus diisi',
            'minimum_score.integer' => 'Nilai minimal harus berupa angka',
            'retry_delay.integer' => 'Waktu tunggu harus berupa angka',
        ];
    }
}
