<?php

namespace WorkingCode\Hw4\Validator;

class NotEmptyValidator
{
    public function validate(string $message): bool
    {
        return !empty($message);
    }
}
