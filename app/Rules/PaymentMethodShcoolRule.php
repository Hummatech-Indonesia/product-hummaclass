<?php

namespace App\Rules;

use App\Enums\PaymentMethodSchoolEnum;
use Closure;
use Illuminate\Contracts\Validation\Rule;

class PaymentMethodShcoolRule implements Rule
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
        return in_array(strtolower($value), [PaymentMethodSchoolEnum::FROMSCHOOL->value, PaymentMethodSchoolEnum::FROMSTUDENT->value]);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'Metode Pembayaran yang anda pilih tidak valid';
    }
}
