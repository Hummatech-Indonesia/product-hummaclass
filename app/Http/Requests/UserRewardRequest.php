<?php

namespace App\Http\Requests;

use App\Enums\RewardStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UserRewardRequest extends ApiRequest
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
            'status' => ['required', new Enum(RewardStatusEnum::class)],
            'message' => 'nullable|string'
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
            'status.required' => 'status wajib diisi',
        ];
    }
}
