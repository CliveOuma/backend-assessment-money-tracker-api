<?php

namespace App\Http\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidAmount implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Check if numeric
        if (!is_numeric($value)) {
            $fail('The :attribute must be a number.');
            return;
        }

        $amount = (float) $value;
        
        // Check minimum amount
        if ($amount < 0.01) {
            $fail('The :attribute must be at least 0.01.');
            return;
        }

        // Check maximum amount (prevent extremely large values)
        if ($amount > 999999999.99) {
            $fail('The :attribute cannot exceed 999,999,999.99.');
            return;
        }

        // Check decimal places (max 2)
        if (strlen(substr(strrchr((string)$value, "."), 1)) > 2) {
            $fail('The :attribute cannot have more than 2 decimal places.');
        }
    }
}
