<?php

namespace App\Http\Requests;

use App\Rules\PaymentMethodShcoolRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentMethodSchoolRequest extends ApiRequest
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
            'payment_method' => ['required', new PaymentMethodShcoolRule()],
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
            'payment_method.required' => 'Metode pembayaran wajib diisi'
        ];
    }
}
