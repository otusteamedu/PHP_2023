<?php

declare(strict_types=1);

namespace App\Infrastructure\Middleware;

use App\Application\Middleware\RequestInterface;
use Symfony\Component\HttpFoundation\RequestStack;

final class Request implements RequestInterface
{
    public function __construct(
        private readonly RequestStack $requestStack,
    ) {
    }

    public function getClientIp(): ?string
    {
        return $this->requestStack->getCurrentRequest()->getClientIp();
    }
}
