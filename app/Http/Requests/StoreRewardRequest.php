<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRewardRequest extends ApiRequest
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
            'name' => 'required',
            'description' => 'required',
            'points_required' => 'required|integer',
            'image' => 'required|image|mimes:png,jpg'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'description.required' => 'Deskripsi wajib diisi.',
            'points_required.required' => 'Poin yang dibutuhkan wajib diisi.',
            'points_required.integer' => 'Poin yang dibutuhkan harus berupa angka.',
            'image.required' => 'Gambar wajib diisi.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Gambar harus berformat PNG atau JPG.'
        ];
    }
}