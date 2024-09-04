<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModulRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|max:255|unique:moduls,id',
            'course_id' => 'required|exists:courses,id',
            'sub_title' => 'required|max:255',
        ];
    }
}
