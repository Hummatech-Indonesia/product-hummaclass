<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubModuleRequest extends ApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'module_id' => 'required|exists:modules,id',
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('sub_modules')->ignore($this->route('sub_module')),
            ],
            'sub_title' => 'required|string|max:255',
            'content' => 'required|string',
            'url_youtube' => 'required|url',
        ];
    }

    public function messages(): array
    {
        return [
            'module_id.required' => 'ID module wajib diisi.',
            'module_id.exists' => 'ID module tidak valid.',
            'title.required' => 'Judul wajib diisi.',
            'title.unique' => 'Judul sudah digunakan.',
            'sub_title.required' => 'Sub-judul wajib diisi.',
            'sub_title.string' => 'Sub-judul harus berupa teks.',
            'sub_title.max' => 'Sub-judul maksimal :max karakter.',
            'content.required' => 'Konten wajib diisi.',
            'content.string' => 'Konten harus berupa teks.',
            'url_youtube.required' => 'URL YouTube wajib diisi.',
            'url_youtube.url' => 'URL YouTube tidak valid.',
        ];
    }
}
