<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DiscussionRequest extends ApiRequest
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
            'module_id' => 'required',
            'discussion_title' => 'required',
            'discussion_question' => 'required',
            'tag' => 'required|array|max:6',
            'tag.*' => 'string'
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
            'module_id.required' => 'Modul wajib diisi',
            'discussion_title.required' => 'Judul diskusi wajib diisi',
            'discussion_question.required' => 'Pertanyaan diskusi wajib diisi',
            'tag.required' => 'Tag wajib diisi',
            'tag.array' => 'Tag harus berupa array',
            'tag.max' => 'Tag maksimal sebanyak 6',
        ];
    }
}
