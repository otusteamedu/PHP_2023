<?php

declare(strict_types=1);

namespace App\Infrastructure\Component\RateLimiter;

use App\Application\Component\RateLimiter\RateLimiterInterface;
use App\Infrastructure\Component\RedisClient;

final class RateLimiter implements RateLimiterInterface
{
    public const RATE_LIMIT_KEY = 'rate_limit';

    public function __construct(
        private readonly RedisClient $client,
        private readonly int $limit,
    ) {
    }

    public function incrementLimit(): void
    {
        if (false === $this->client->getRedis()->get(self::RATE_LIMIT_KEY)) {
            $this->client->getRedis()->set(self::RATE_LIMIT_KEY, '1', 60 - date('s'));

            return;
        }

        $this->client->getRedis()->incr(self::RATE_LIMIT_KEY);
    }

    public function isLimitExceeded(): bool
    {
        return (int) $this->client->getRedis()->get(self::RATE_LIMIT_KEY) > $this->limit;
    }
}
