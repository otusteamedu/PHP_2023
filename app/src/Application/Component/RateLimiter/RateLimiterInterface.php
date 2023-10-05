<?php

declare(strict_types=1);

namespace App\Application\Component\RateLimiter;

interface RateLimiterInterface
{
    public function incrementLimit(): void;

    public function isLimitExceeded(): bool;
}
