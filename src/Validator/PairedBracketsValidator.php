<?php

namespace WorkingCode\Hw4\Validator;

class PairedBracketsValidator
{
    public function validate(string $message): bool
    {
        $countOpenBrackets  = preg_match_all('/\(/', $message);
        $countCloseBrackets = preg_match_all('/\)/', $message);

        return $countOpenBrackets > 0
            && $countCloseBrackets > 0
            && $countOpenBrackets === $countCloseBrackets;
    }
}
