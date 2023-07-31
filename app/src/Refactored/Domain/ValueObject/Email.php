<?php

declare(strict_types=1);

namespace Imitronov\Hw15\Refactored\Domain\ValueObject;

use Imitronov\Hw15\Refactored\Domain\Exception\InvalidArgumentException;

final class Email
{
    private readonly string $value;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(string $value)
    {
        assert(
            strlen(sprintf('%s', $value)) > 0,
            new InvalidArgumentException('Email не может быть пустым.'),
        );
        assert(
            false !== filter_var($value, FILTER_VALIDATE_EMAIL, FILTER_FLAG_EMAIL_UNICODE),
            new InvalidArgumentException('Некорректный Email.'),
        );

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
