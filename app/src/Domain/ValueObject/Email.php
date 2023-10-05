<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use App\Domain\Exception\Error;

final class Email
{
    private string $value;

    public function __construct(string $value)
    {
        assert(
            strlen(sprintf('%s', $value)) > 0,
            new Error('Email не может быть пустым.'),
        );

        assert(
            false !== filter_var($value, FILTER_VALIDATE_EMAIL, FILTER_FLAG_EMAIL_UNICODE),
            new Error('Некорректный Email.'),
        );

        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
