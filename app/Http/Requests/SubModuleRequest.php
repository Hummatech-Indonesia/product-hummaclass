<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubModuleRequest extends ApiRequest
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
            'title' => 'required|max:255',
            'sub_title' => 'required|max:255',
            'content' => 'required',
            'url_youtube' => 'nullable|url',
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
            'sub_title' => 'Sub judul wajib diisi',
            'content' => 'Konten wajib diisi',
            'url_youtube' => 'Url youtube wajib diisi',
        ];
    }
}
