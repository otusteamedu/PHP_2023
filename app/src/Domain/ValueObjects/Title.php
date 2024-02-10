<?php

declare(strict_types=1);

namespace Yevgen87\App\Domain\ValueObjects;

use InvalidArgumentException;

class Title
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
        if (strlen($value) > 200) {
            throw new InvalidArgumentException('Title must be less than 200 characters');
        }
    }
}
