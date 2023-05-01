<?php

declare(strict_types=1);

namespace Twent\BracketsValidator\Application\DTO;

use Twent\BracketsValidator\Application\Exceptions\EmptyString;

final class StringDTO
{
    /**
     * @throws EmptyString
     */
    public function __construct(
        protected ?string $value
    ) {
        $this->assertNotEmpty();
    }

    public function getValue(): ?string
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
}
