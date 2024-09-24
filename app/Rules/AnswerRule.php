<?php

namespace App\Rules;

use App\Enums\AnswerEnum;
use Closure;
use Illuminate\Contracts\Validation\Rule;

class AnswerRule implements Rule
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
        return in_array(strtolower($value), [AnswerEnum::OPTION_A->value, AnswerEnum::OPTION_B->value, AnswerEnum::OPTION_C->value, AnswerEnum::OPTION_D->value, AnswerEnum::OPTION_E->value]);
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
