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
}