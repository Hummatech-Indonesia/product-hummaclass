<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRewardRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Ubah menjadi 'true' agar request ini dapat diizinkan
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|required',
            'description' => 'sometimes|required',
            'points_required' => 'sometimes|required|integer',
            'image' => 'nullable|image|mimes:png,jpg'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'description.required' => 'Deskripsi wajib diisi.',
            'points_required.required' => 'Poin yang dibutuhkan wajib diisi.',
            'points_required.integer' => 'Poin yang dibutuhkan harus berupa angka.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Gambar harus berformat PNG atau JPG.'
        ];
    }
}
