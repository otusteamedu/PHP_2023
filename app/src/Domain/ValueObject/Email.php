<?php

namespace App\Domain\ValueObject;

use InvalidArgumentException;

class Email extends AbstractValueObject
{
    /**
     * @param string $value
     * @return void
     * @throws InvalidArgumentException
     */
    protected function validation(string $value): void
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Неверный формат email адреса');
        }
    }
}
