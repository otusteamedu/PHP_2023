<?php

namespace App\Domains\Order\Domain\ValueObjects;

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

    private function assertValidDescription(string $name): void
    {
        $strlen = mb_strlen($name);
        if ($strlen < 2 || $strlen > 255) {
            throw new \InvalidArgumentException('Описание продукта не валидно');
        }
    }
}
