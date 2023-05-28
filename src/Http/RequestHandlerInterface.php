<?php

declare(strict_types=1);

namespace Otus\App\Http;

interface RequestHandlerInterface
{
    public function handle(Request $request): Response;
}
