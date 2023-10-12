<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use App\Domain\Exception\Error;

final class Number
{
    private string $value;

    public function __construct(string|float $value)
    {
        assert(
            strlen(sprintf('%s', $value)) > 0,
            new Error('Число не может быть пустым.'),
        );

        assert(
            is_numeric($value),
            new Error('Некорректное число.'),
        );

        $this->value = (string) $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
