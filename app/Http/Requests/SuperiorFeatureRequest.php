<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuperiorFeatureRequest extends ApiRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|max:255',
            'description' => 'required|max:500',
            'mentor' => 'required',
            'course' => 'required',
            'task' => 'required'
        ];
    }

    /**
     * messages
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Judul harus diisi.',
            'title.max' => 'Judul tidak boleh lebih dari 255 karakter.',
            'description.required' => 'Deskripsi harus diisi.',
            'description.max' => 'Deskripsi tidak boleh lebih dari 500 karakter.',
            'mentor.required' => 'Mentor harus dipilih.',
            'course.required' => 'Kursus harus dipilih.',
            'task.required' => 'Tugas harus diisi.',
        ];
    }
}
