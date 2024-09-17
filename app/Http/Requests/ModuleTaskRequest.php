<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ModuleTaskRequest extends ApiRequest
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
            'number_of' => [
                'required',
                'integer',
                Rule::unique('module_tasks')->ignore($this->route('module_task')),
            ],
            'question' => 'required|string|max:500',
        ];
    }
    public function messages(): array
    {
        return [
            'number_of.required' => 'nomor wajib diisi',
            'number_of.unique' => 'nomor sudah digunakan',
            'question.required' => 'pertanyaan wajib diisi'
        ];
    }
}
