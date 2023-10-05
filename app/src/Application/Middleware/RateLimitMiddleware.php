<?php

declare(strict_types=1);

namespace App\Application\Middleware;

use App\Application\Component\RateLimiter\RateLimiterInterface;
use App\Domain\Exception\TooManyRequestsException;

final class RateLimitMiddleware extends Middleware
{
    public function __construct(
        private readonly RateLimiterInterface $rateLimiter,
    ) {
    }

    /**
     * @throws TooManyRequestsException
     */
    public function handle(RequestInterface $request): ?RequestInterface
    {
        $this->rateLimiter->incrementLimit();

        if ($this->rateLimiter->isLimitExceeded()) {
            throw new TooManyRequestsException('Too many requests!');
        }

        return parent::handle($request);
    }
}
