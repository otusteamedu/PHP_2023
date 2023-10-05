<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use App\Domain\Exception\Error;

final class NotEmptyString
{
    private string $value;

    public function __construct(string $value)
    {
        assert(
            strlen(sprintf('%s', $value)) > 0,
            new Error('Строка не может быть пустой.'),
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

    public function isEq(self $notEmptyString): bool
    {
        return 0 === strcasecmp($this->value, $notEmptyString->getValue());
    }

    public function isEqString(string $string): bool
    {
        return 0 === strcasecmp($this->value, $string);
    }
}
