<?php

namespace App\Infrastructure\Http;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class TestActionPost
{
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        $data = (array) $request->getParsedBody();
        print_r($data);

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }
}
