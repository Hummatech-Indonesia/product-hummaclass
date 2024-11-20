<?php

namespace App\Http\Requests;

use App\Rules\GenderRule;
use Illuminate\Foundation\Http\FormRequest;

class UserStudentRequest extends ApiRequest
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
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required',
            'gender' => ['required', new GenderRule()],
            'address' => 'required',
            'nisn' => 'required',
            'date_birth' => 'required'
        ];
    }

    public function message()
    {
        return [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email salah',
            'email.unique' => 'Email sudah terdaftar',
            'phone_number.required' => 'Nomor telepon harus diisi',
            'phone_number.integer' => 'Nomor telepon harus berupa angka',
            'phone_number.max' => 'Nomor telepon maksimal 15 karakter',
            'gender.required' => 'Jenis kelamin harus diisi',
            'address.required' => 'Alamat harus diisi',
            'gender.in' => 'Jenis kelamin haruslah laki-laki atau perempuan',
        ];
    }
}
