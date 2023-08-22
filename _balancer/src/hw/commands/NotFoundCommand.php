<?php

namespace Ndybnov\Hw04\hw\commands;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class NotFoundCommand
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
        return $response->withStatus(404);
    }
}
