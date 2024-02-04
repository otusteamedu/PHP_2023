<?php

declare(strict_types=1);

namespace Yevgen87\App\Domain\ValueObjects;

use InvalidArgumentException;

class Url
{
    private string $value;

    public function __construct(string $value)
    {
        // $this->isValid($value);
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }

    private function isValid(string $value)
    {   if (!filter_var($value, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException('Invalid url');
        }
    }
}
