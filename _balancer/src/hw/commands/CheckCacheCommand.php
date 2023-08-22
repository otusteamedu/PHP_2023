<?php

declare(strict_types=1);

namespace Ndybnov\Hw04\hw\commands;

use Ndybnov\Hw04\hw\UsingCache;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CheckCacheCommand
{
    private function __construct()
    {
    }

    public static function build(): self
    {
        return new self();
    }

    public function run(Request $request, Response $response): Response
    {
        (new UsingCache())->run();

        return $response->withStatus(200);
    }
}
