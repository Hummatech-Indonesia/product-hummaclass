<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends ApiRequest
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
            'old_password' => 'required',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'old_password.required' => ":Password lama harus diisi",
            'password.required' => ":Password baru harus diisi",
            'password_confirmation.required' => "Konfirmasi password harus diisi",
            'old_password.current_password' => "Password lama yang anda masukkan salah",
            'password.min' => ":attribute minimal 8 karakter",
            'password.confirmed' => ":attribute konfirmasi password harus sama"
        ];
    }
}
