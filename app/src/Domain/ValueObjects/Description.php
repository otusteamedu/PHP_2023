<?php

declare(strict_types=1);

namespace Yevgen87\App\Domain\ValueObjects;

use InvalidArgumentException;

class Description
{
    private string $value;

    public function __construct(string $value)
    {
        $this->isValid($value);
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }

    private function isValid(string $value)
    {
        if (strlen($value) > 10_000) {
            throw new InvalidArgumentException('Title must be less than 10000 characters');
        }
    }
}
