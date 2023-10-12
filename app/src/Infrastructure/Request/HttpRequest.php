<?php

declare(strict_types=1);

namespace App\Infrastructure\Request;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

abstract class HttpRequest
{
    public function __construct(
        private readonly RequestStack $requestStack,
    ) {
    }

    public function getRequest(): Request
    {
        return $this->requestStack->getCurrentRequest();
    }
}
