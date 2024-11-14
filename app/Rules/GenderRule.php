<?php

namespace App\Rules;

use App\Enums\AnswerEnum;
use App\Enums\GenderEnum;
use Closure;
use Illuminate\Contracts\Validation\Rule;

class GenderRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return in_array(strtolower($value), [GenderEnum::MALE->value, GenderEnum::FEMALE->value]);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'Jawaban yang anda pilih tidak valid';
    }
}
