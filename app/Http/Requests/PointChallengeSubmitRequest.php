<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PointChallengeSubmitRequest extends FormRequest
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
            'challenge_submit' => 'required|array',
            'challenge_submit.*.student_id' => 'required|exists:students,id',
            'challenge_submit.*.point' => 'required|min:1|max:3',
        ];
    }
}
