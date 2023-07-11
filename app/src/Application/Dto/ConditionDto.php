<?php

declare(strict_types=1);

namespace Imitronov\Hw12\Application\Dto;

final class ConditionDto
{
    public function __construct(
        public readonly string $key,
        public readonly string|int $value,
    ) {
    }
}
