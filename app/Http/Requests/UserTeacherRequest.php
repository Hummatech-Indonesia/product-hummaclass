<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserTeacherRequest extends ApiRequest
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
            'photo' => 'nullable',
            'name' => 'required',
            'email' => 'required',
            'nip' => 'required',
            'date_birth' => 'required',
            'religion' => 'required',
            'phone_number' => 'required',
            'gender' => 'required',
            'address' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'photo.nullable' => 'Foto tidak wajib diisi.',
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'nip.required' => 'NIP wajib diisi.',
            'date_birth.required' => 'Tanggal lahir wajib diisi.',
            'religion.required' => 'Agama wajib diisi.',
            'phone_number.required' => 'Nomor telepon wajib diisi.',
            'gender.required' => 'Jenis kelamin wajib diisi.',
            'address.required' => 'Alamat wajib diisi.',
        ];
    }

}
