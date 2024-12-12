<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ZoomUpdateRequest extends FormRequest
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
            'title' => 'required',
            'school_id' => 'required|exists:schools,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'user_id' => 'required|exists:users,id',
            'link' => 'required|url', 
            'date' => 'required',
        ];
    }

        /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Judul wajib diisi.',
            'school_id.required' => 'Sekolah wajib dipilih.',
            'school_id.exists' => 'Sekolah yang dipilih tidak valid.',
            'classroom_id.required' => 'Kelas wajib dipilih.',
            'classroom_id.exists' => 'Kelas yang dipilih tidak valid.',
            'user_id.required' => 'Pengguna wajib dipilih.',
            'user_id.exists' => 'Pengguna yang dipilih tidak valid.',
            'link.required' => 'Link wajib diisi.',
            'link.url' => 'Link harus berupa URL yang valid.',
            'date.required' => 'Tanggal wajib diisi.',
            'date.date_format' => 'Tanggal harus dalam format Y-m-d H:i (contoh: 2024-12-06 15:30).',
        ];
    }
}
