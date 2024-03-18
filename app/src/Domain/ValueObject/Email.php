<?php

namespace App\Domain\ValueObject;

use InvalidArgumentException;

class Email extends AbstractValueObject
{
    /**
     * @param string $value
     * @return bool
     * @throws InvalidArgumentException
     */
    protected function validation(string $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }
}
