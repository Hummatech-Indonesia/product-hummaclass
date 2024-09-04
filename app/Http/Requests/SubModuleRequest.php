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
            'module_id' => 'required',
            'title' => 'required',
            'sub_title' => 'required',
            'content' => 'required',
            'url_youtube' => 'required',
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
            'module_id.required' => 'Id module wajib diisi',
            'title.required' => 'Judul wajib diisi',
            'sub_title' => 'Sub judul wajib diisi',
            'content' => 'Konten wajib diisi',
            'url_youtube' => 'Url youtube wajib diisi',
        ];
    }
}
