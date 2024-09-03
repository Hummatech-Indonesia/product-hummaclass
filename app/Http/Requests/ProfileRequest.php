<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends ApiRequest
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
            'email' => 'required|email|unique:users',
            'phone_number' => 'required',
            'address' => 'required|string|max:500',
            'photo' => 'nullable|mimes:png,jpg|image',
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
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'phone_number.required' => 'Nomor telepon wajib diisi',
            'address.required' => 'Alamat wajib diisi',
            'address.string' => 'Alamat harus berupa teks',
            'address.max' => 'Alamat maksimal :max karakter',
            'photo.mimes' => 'Foto harus berupa file dengan ekstensi png atau jpg',
            'photo.image' => 'Foto harus berupa gambar',
        ];
    }
}
