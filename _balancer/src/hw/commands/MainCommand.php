<?php

declare(strict_types=1);

namespace Ndybnov\Hw04\hw\commands;

use Ndybnov\Hw04\hw\ParameterString;
use Ndybnov\Hw04\hw\ParseString;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class MainCommand
{
    private function __construct()
    {
    }

    public static function build(): self
    {
        return new self();
    }

    /**
     * @throws \JsonException
     */
    public function run(Request $request, Response $response): Response
    {
        $string = ParameterString::build()->getValue($request);

        $result = ParseString::build()->makeResult($string);

        $body = [
            'received' => $result->getString(),
            'info' => $result->getInfoMessage(),
        ];

        $response->getBody()->write(\json_encode($body, JSON_THROW_ON_ERROR));

        return $response->withStatus($result->getStatusCode());
    }
}
