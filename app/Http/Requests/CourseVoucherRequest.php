<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseVoucherRequest extends ApiRequest
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
            'code' => 'required|string|max:255',
            'discount' => 'required|integer|between:1,100',
            'usage_limit' => 'required|integer|min:1',
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
            'code.required' => 'Kode wajib diisi',
            'discount.required' => 'Diskon wajib diisi',
            'discount.between' => 'Diskon antara 1 sampai 100',
            'usage_limit.min'=>'Batas penggunaan minimal :min',
            'usage_limit.required' => 'Batas Penggunaan wajib diisi',
        ];
    }
}
