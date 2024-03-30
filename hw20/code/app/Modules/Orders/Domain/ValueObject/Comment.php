<?php

declare(strict_types=1);

namespace App\Modules\Orders\Domain\ValueObject;

class Comment
{
    private string $value;
    public function __construct(string $value)
    {
        $this->assertValidValue($value);
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    private function assertValidValue(string $value) : void
    {
        $minLen = 1;
        $maxLen = 1000;
        $valueLen = mb_strlen($value);
        if ($valueLen < $minLen || $valueLen > $maxLen) {
            throw new \InvalidArgumentException('Поле "Комментарий" невалидно');
        }
    }
}
