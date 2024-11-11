<?php

namespace App\Http\Requests\IndustryClass;

use App\Http\Requests\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class SchoolUpdateRequest extends ApiRequest
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
            'photo' => 'nullable|mimes:png,jpg,jpeg',
            'description' => 'required',
            'phone_number' => 'required',
            'npsn' => 'required'
        ];
    }
}
