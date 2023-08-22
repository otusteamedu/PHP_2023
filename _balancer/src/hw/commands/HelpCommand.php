<?php

namespace Ndybnov\Hw04\hw\commands;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class HelpCommand
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
        $body = [
            'Please use one of:',
            '`/` - route-post-request - for post-requests;',
            '`/check-cache/` - route-get-request - open in web-browser, it is check work cache;',
            '`/` - route-get-request - open in web-browses, you can read that short help.',
        ];

        $response->getBody()->write(implode('<br>', $body));

        return $response->withStatus(200);
    }
}
