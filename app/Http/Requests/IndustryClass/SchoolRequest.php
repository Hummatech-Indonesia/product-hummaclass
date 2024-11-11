<?php

namespace App\Http\Requests\IndustryClass;

use App\Http\Requests\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class SchoolRequest extends ApiRequest
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
            'address' => 'required',
            'head_master' => 'required',
            'photo' => 'required|mimes:png,jpg,jpeg',
            'description' => 'required',
            'phone_number' => 'required',
            'npsn' => 'required',
            'email' => 'required|email'
        ];
    }

    /**
     * messages
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama sekolah wajib diisi.',
            'address.required' => 'Alamat wajib diisi.',
            'head_master.required' => 'Nama kepala sekolah wajib diisi.',
            'photo.required' => 'Logo sekolah wajib diunggah.',
            'photo.mimes' => 'Logo sekolah harus berupa file dengan format: png, jpg, atau jpeg.',
            'description.required' => 'Deskripsi wajib diisi.',
            'phone_number.required' => 'Nomor telepon wajib diisi.',
            'npsn.required' => 'NPSN wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.'
        ];
    }
}
