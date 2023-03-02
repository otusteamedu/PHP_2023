<?php

declare(strict_types=1);

namespace Imitronov\Hw4\UseCase\BracketsString;

final class BracketsStringValidationResult
{
    public function __construct(
        public readonly string $string,
        public readonly bool $isValid,
        public readonly string $message,
    ) {
    }
}
