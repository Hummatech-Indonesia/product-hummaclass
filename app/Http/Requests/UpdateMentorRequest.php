<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMentorRequest extends FormRequest
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
            'address' => 'required',
            'rekening_number' => 'nullable',
            'bank_name' => 'nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'phone_number.required' => 'Nomor telepon wajib diisi',
            'address.required' => 'Alamat wajib diisi',
        ];
    }
}
