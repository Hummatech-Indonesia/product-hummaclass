<?php

namespace App\Http\Requests;

use App\Rules\GenderRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreMentorRequest extends FormRequest
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
            'name' => 'required|max:255',
            'gender' => ['required', new GenderRule()],
            'email' => 'required|email|unique:users|max:255',
            'phone_number' => 'required|max_digits:20',
            'address' => 'required|max:1000',
            'rekening_number' => 'nullable|max_digits:20',
            'bank_name' => 'nullable|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama wajib diisi',
            'name.max' => 'Nama maksimal :max karakter',
            'gender.required' => 'Jenis kelamin wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.max' => 'Email maksimal :max karakter',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'phone_number.required' => 'Nomor telepon wajib diisi',
            'phone_number.max_digits' => 'Nomor teepon maksimal :max karakter',
            'address.required' => 'Alamat wajib diisi',
            'address.max' => 'Alamat maksimal :max karakter',
            'rekening_number.max_digits' => 'Nomor rekening maksimal 20 digit',
            'bank_name.max' => 'Nama alamat maksimal :max karakter'
        ];
    }
}
