<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmissionTaskRequest extends ApiRequest
{
    private $mimes = 'png,jpg,jpeg,zip,rar';
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
            'answer' => 'nullable|string|max:255',
            'file' => 'required|mimes:' . $this->mimes
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
            'answer.string' => 'Jawaban harus berupa text',
            'file.required' => 'File wajib diisi',
            'file.mimes' => 'File harus berformat ' . $this->mimes,
        ];
    }
}
