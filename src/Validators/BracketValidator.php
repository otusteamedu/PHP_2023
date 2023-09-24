<?php

declare(strict_types=1);

namespace App\Validators;

class BracketValidator
{
    public static function validateString(string $string): bool
    {
        if (preg_match('/^(\((?1)*\))*$/', $string)) {
            return true;
        } else {
            return false;
        }
    }
}
