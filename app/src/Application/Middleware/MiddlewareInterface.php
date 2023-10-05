<?php

declare(strict_types=1);

namespace App\Application\Middleware;

interface MiddlewareInterface
{
    public function setNext(self $handler): self;

    public function handle(RequestInterface $request): ?RequestInterface;
}
