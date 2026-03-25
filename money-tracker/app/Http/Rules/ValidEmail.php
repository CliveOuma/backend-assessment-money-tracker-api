<?php

namespace App\Http\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidEmail implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Enhanced email validation
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $fail('The :attribute must be a valid email address.');
            return;
        }

        // Check for common disposable email domains
        $disposableDomains = [
            'tempmail.org', '10minutemail.com', 'guerrillamail.com',
            'mailinator.com', 'throwaway.email'
        ];

        $domain = substr(strrchr($value, "@"), 1);
        if (in_array($domain, $disposableDomains)) {
            $fail('Disposable email addresses are not allowed.');
        }
    }
}
