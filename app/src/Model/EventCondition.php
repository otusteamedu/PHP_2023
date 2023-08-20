<?php

declare(strict_types=1);

namespace App\Model;

readonly class EventCondition
{
    public function __construct(
        public string $key,
        public string $value,
    ) {
    }
}