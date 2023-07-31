<?php

declare(strict_types=1);

namespace Imitronov\Hw15\Refactored\Domain\ValueObject;

use Imitronov\Hw15\Refactored\Domain\Exception\InvalidArgumentException;

final class NotEmptyString
{
    private readonly string|int $value;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(string|int $value)
    {
        assert(
            strlen(sprintf('%s', $value)) > 0,
            new InvalidArgumentException('Строка не может быть пустой.'),
        );

        $this->value = $value;
    }

    public function getValue(): string|int
    {
        return $this->value;
    }
}
