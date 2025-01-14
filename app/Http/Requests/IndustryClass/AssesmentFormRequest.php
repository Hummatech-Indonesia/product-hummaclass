<?php

namespace App\Http\Requests\IndustryClass;

use App\Http\Requests\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class AssesmentFormRequest extends ApiRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'indicator' => 'required|array',
            'indicator.*' => 'required|max:255',
        ];
    }

    /**
     * messages
     *
     * @return void
     */
    public function messages(): array
    {
        return [
            'indicator.required' => 'Indikator wajib diisi',
            'indicator.array' => 'Indikator harus bertipe array',
            'indicator.*.max' => 'Indikator maksimal 255 karakter'
        ];
    }
}
