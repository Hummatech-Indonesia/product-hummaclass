<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BlogRequest extends ApiRequest
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
            'thumbnail' => 'nullable|image|mimes:png,jpg',
            'title' => [
                'required',
                'string',
                'max:255',
                'title' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('blogs')->ignore($this->route('blog')),
                ],
            ],
            'category_id' => 'required',
            'description' => 'required',
            'sub_category_id' => 'required',
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
            'thumbnail.mimes' => 'Thumbnail harus berupa gambar dengan format png atau jpg.',
            'title.required' => 'Judul wajib diisi.',
            'title.string' => 'Judul harus berupa teks.',
            'title.max' => 'Judul tidak boleh lebih dari 255 karakter.',
            'description.required' => 'Deskripsi wajib diisi.',
            'sub_category_id.required' => 'Sub kategori wajib dipilih.',
            'category_id.required' => 'Kategori wajib dipilih.',
        ];
    }

}
