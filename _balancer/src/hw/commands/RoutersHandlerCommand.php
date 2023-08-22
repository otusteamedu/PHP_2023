<?php

namespace Ndybnov\Hw04\hw\commands;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class RoutersHandlerCommand
{
    private function __construct()
    {
    }

    public static function build(): self
    {
        return new self();
    }

    public function make(string $flag): \Closure
    {
        return match ($flag) {
            'get-root' => static function (Request $request, Response $response): Response {
                return HelpCommand::build()->run($request, $response);
            },

            'post-root' => static function (Request $request, Response $response): Response {
                return MainCommand::build()->run($request, $response);
            },

            'get-check-cache' => static function (Request $request, Response $response): Response {
                return CheckCacheCommand::build()->run($request, $response);
            },

            default => static function (Request $request, Response $response): Response {
                return NotFoundCommand::build()->run($request, $response);
            }
        };
    }
}
