<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CourseRequest extends ApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sub_category_id' => 'required|exists:sub_categories,id',
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('courses')->ignore($this->route('course')),
            ],
            'sub_title' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'is_premium' => 'required|boolean',
            'price' => 'required|integer|min:0',
            'photo' => 'nullable|mimes:png,jpg,jpeg|max:2048'
        ];
    }

    public function messages(): array
    {
        return [
            'photo.mimes' => 'Photo harus berformat png, jpg, atau jpeg.',
            'photo.max' => 'Ukuran photo maksimal 2MB.',
            'sub_category_id.required' => 'Sub-kategori wajib diisi.',
            'sub_category_id.exists' => 'Sub-kategori tidak valid.',
            'title.required' => 'Judul wajib diisi.',
            'title.unique' => 'Judul sudah digunakan.',
            'sub_title.required' => 'Sub-judul wajib diisi.',
            'description.required' => 'Deskripsi wajib diisi.',
            'description.max' => 'Deskripsi maksimal :max karakter.',
            'is_premium.required' => 'Status premium wajib diisi.',
            'is_premium.boolean' => 'Status premium harus berupa true atau false.',
            'price.required' => 'Harga wajib diisi.',
            'price.integer' => 'Harga harus berupa angka.',
            'price.min' => 'Harga tidak boleh negatif.',
        ];
    }
}
