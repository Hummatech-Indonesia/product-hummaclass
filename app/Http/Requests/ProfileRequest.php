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
            'phone_number' => 'required|regex:/^0[0-9]{9,12}$/',
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
            'address.required' => 'Alamat wajib diisi',
            'address.max' => 'Alamat maksimal :max karakter',
            'phone_number.required' => 'Nomor telepon wajib diisi',
        ];
    }
}
