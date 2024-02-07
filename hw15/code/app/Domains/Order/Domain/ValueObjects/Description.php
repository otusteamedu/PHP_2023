<?php

namespace App\Domains\Order\Domain\ValueObjects;

use http\Exception\InvalidArgumentException;

class Description
{
    private string $description;

    public function __construct(string $description)
    {
        $this->assertValidDescription($description);
        $this->description = $description;
    }

    public function getValue(): string
    {
        return $this->description;
    }

    private function assertValidDescription(string $description): void
    {
        $minStrlen = 2;
        $maxStrlen = 255;
        $strlen = mb_strlen($description);
        if ($strlen < $minStrlen || $strlen > $maxStrlen) {
            throw new InvalidArgumentException("Длинна поля описания должна быть от {$minStrlen} до {$maxStrlen} символов");
        }
    }
}
