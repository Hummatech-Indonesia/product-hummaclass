<?php

namespace App\Http\Requests\IndustryClass;

use App\Http\Requests\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class ClassroomRequest extends ApiRequest
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
            'division_id' => 'required',
            'name' => 'required',
            'class_level' => 'required'
        ];
    }
}