<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckDocumentExistsRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    protected $document_index;
    public function __construct($document_index=null)
    {
        $this->document_index=$document_index;
    }
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(!preg_match('/^\d{10}$/', $value)){
            $fail(':attribute is not a valid  number');
        }
    }
    protected function isValid($data){
        return false;
    }
}
