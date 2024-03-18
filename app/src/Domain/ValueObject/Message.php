<?php

namespace App\Domain\ValueObject;

use InvalidArgumentException;

class Message extends AbstractValueObject
{
    /**
     * @param string $value
     * @return bool
     * @throws InvalidArgumentException
     */
    protected function validation(string $value): bool
    {
        return !empty($value);
    }
}
