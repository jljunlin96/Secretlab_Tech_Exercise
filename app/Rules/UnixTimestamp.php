<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class UnixTimestamp implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // If the value is null, return
        if (is_null($value)){
            return;
        }

        // Check if the value is a valid Unix timestamp
        if (!is_numeric($value) || (int)$value < 0) {
            $fail('The :attribute must be a valid Unix timestamp.');
        }
    }
}
