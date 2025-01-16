<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PhoneUARule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (is_null($value)) {
            return;
        }

        $phonePattern = '/^[\+]{0,1}380([0-9]{9})$/';

        if (!preg_match($phonePattern, $value)) {
            $fail("The $attribute must be a valid number of Ukraine.");
        }
    }
}
