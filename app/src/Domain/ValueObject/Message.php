<?php

namespace App\Domain\ValueObject;

use InvalidArgumentException;

class Message extends AbstractValueObject
{
    /**
     * @param string $value
     * @return void
     * @throws InvalidArgumentException
     */
    protected function validation(string $value): void
    {
        // Проверяем, что сообщение не пустое
        if (empty($value)) {
            throw new InvalidArgumentException('Сообщение не может быть пустым');
        }
    }
}
