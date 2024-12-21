<?php

namespace App\Rules;

use App\Models\verification\appointing_authorities;
use App\our_modules\reuse_modules\ReuseModule;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class checkStateCredentialsRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    protected $table;
    public function __construct($table)
    {
        $this->table = $table;
    }
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $user_name = request('user_name');
        $department_id = request('department');
        if (ReuseModule::checkStateUserCreden($user_name,$department_id)) {
            $fail('user_name and departmentis already assign !');
        }
    }
}
