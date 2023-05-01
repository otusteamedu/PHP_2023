<?php

declare(strict_types=1);

namespace Twent\BracketsValidator\Domain\ValueObject;

use Twent\BracketsValidator\Application\Exceptions\EmptyString;
use Twent\BracketsValidator\Application\Exceptions\InvalidArgument;

final class InputString
{
    /**
     * @throws EmptyString
     * @throws InvalidArgument
     */
    public function __construct(
        protected string $value
    ) {
        $this->assertNotEmpty();
        $this->getCleanString();
        $this->isOneCharCheck();
    }

    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @throws EmptyString
     */
    private function assertNotEmpty(): void
    {
        if (! $this->value) {
            throw new EmptyString();
        }
    }

    /**
     * @throws EmptyString
     */
    private function getCleanString(): void
    {
        // Удаляем ненужные символы в начале и конце строки
        $this->value = trim($this->value, "\x00..\x24\x5F");
        $this->assertNotEmpty();
    }

    private function isOneCharCheck(): void
    {
        if (strlen($this->value) === 1) {
            throw new InvalidArgument();
        }
    }
}
