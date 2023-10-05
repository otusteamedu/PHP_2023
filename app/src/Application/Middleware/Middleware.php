<?php

declare(strict_types=1);

namespace App\Application\Middleware;

abstract class Middleware implements MiddlewareInterface
{
    private ?MiddlewareInterface $nextHandler = null;

    public function setNext(MiddlewareInterface $handler): MiddlewareInterface
    {
        $this->nextHandler = $handler;

        return $handler;
    }

    public function handle(RequestInterface $request): ?RequestInterface
    {
        if (null !== $this->nextHandler) {
            return $this->nextHandler->handle($request);
        }

        return null;
    }
}
