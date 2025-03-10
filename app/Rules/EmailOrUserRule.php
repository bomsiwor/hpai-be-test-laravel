<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EmailOrUserRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Validate email
        $isEmail = filter_var($value, FILTER_VALIDATE_EMAIL);

        // Validate username
        $pattern  = '^[a-z0-9._]*$';

        if (!$isEmail && !preg_match($pattern, $value)) {
            $fail("Provide valid username or email");
        }
    }
}
