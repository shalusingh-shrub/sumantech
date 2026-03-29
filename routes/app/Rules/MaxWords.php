<?php
namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MaxWords implements ValidationRule
{
    protected $limit;

    public function __construct($limit)
    {
        $this->limit = $limit;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // HTML tags strip karo pehle (CKEditor ke liye)
        $plainText = strip_tags($value);
        $wordCount = count(preg_split('/\s+/', trim($plainText), -1, PREG_SPLIT_NO_EMPTY));

        if ($wordCount > $this->limit) {
            $fail("The {$attribute} may not contain more than {$this->limit} words. Current: {$wordCount} words.");
        }
    }
}
