<?php

namespace App\Domains\Order\Domain\ValueObjects;

use http\Exception\InvalidArgumentException;

class Title
{
    private string $title;

    public function __construct(string $title)
    {
        $this->assertValidTitle($title);
        $this->title = $title;
    }

    public function getValue(): string
    {
        return $this->title;
    }

    private function assertValidTitle(string $title): void
    {
        $minStrlen = 2;
        $maxStrlen = 50;
        $strlen = mb_strlen($title);
        if ($strlen < $minStrlen || $strlen > $maxStrlen) {
            throw new InvalidArgumentException("Длинна поля заголовка должна быть от {$minStrlen} до {$maxStrlen} символов");
        }
    }
}
