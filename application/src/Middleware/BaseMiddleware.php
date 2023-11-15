<?php

declare(strict_types=1);

namespace Gesparo\HW\Middleware;

use Symfony\Component\HttpFoundation\Request;

class BaseMiddleware
{
    private ?BaseMiddleware $next = null;

    public function setNext(BaseMiddleware $next): void
    {
        $this->next = $next;
    }

    public function handle(Request $request)
    {
        if ($this->next) {
            return $this->next->handle($request);
        }

        return null;
    }
}
