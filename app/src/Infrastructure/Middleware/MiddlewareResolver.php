<?php

declare(strict_types=1);

namespace App\Infrastructure\Middleware;

use App\Application\Middleware\MiddlewareInterface;

final class MiddlewareResolver
{
    private mixed $middleware = null;

    /**
     * @param MiddlewareInterface[] $middlewares
     */
    public function __construct(
        iterable $middlewares,
        private readonly Request $request,
    ) {
        $prevMiddleware = null;

        foreach ($middlewares as $middleware) {
            if (null === $this->middleware) {
                $this->middleware = $middleware;
            }

            if (null === $prevMiddleware) {
                $prevMiddleware = $this->middleware;
                continue;
            }

            $prevMiddleware->setNext($middleware);
            $prevMiddleware = $middleware;
        }
    }

    public function onKernelRequest(): void
    {
        $this->middleware->handle($this->request);
    }
}
