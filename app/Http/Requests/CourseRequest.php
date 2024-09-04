<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends ApiRequest
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
            'sub_category_id' => 'required',
            'title' => 'required',
            'sub_title' => 'required',
            'description' => 'required|string|max:500',
            'is_premium' => 'required',
            'price' => 'required|integer',
            'photo' => 'nullable|mimes:png,jpg,jpeg'
        ];
    }
    public function messages(): array
    {
        return [
            'photo.mimes' => 'Photo wajib png,jpg,jpeg',
            'sub_category_id.required' => 'Sub-kategori wajib diisi',
            'title.required' => 'Judul wajib diisi',
            'sub_title.required' => 'Sub-judul wajib diisi',
            'description.required' => 'Deskripsi wajib diisi',
            'description.max' => 'Deskripsi maksimal :max karakter',
            'is_premium.required' => 'Status premium wajib diisi',
            'price.required' => 'Harga wajib diisi',
        ];
    }
}
