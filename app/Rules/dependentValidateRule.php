<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class dependentValidateRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    protected $dependent_value;
    public function __construct($dependent_value)
    {
        $this->dependent_value = $dependent_value;
    }
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $fail(':attribute is require field !');
        if ($this->dependent_value === '2') {
            $fail(':attribute is require field !');
        }
    }
}
