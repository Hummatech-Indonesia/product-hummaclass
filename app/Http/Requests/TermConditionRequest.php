<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TermConditionRequest extends FormRequest
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
            'term_condition' => 'required|string|max:5000',
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
            'term_condition.required' => 'Syarat dan ketentuan wajib diisi',
            'term_condition.max' => 'Syarat dan ketentuan maksimal :max karakter',
        ];
    }
}
