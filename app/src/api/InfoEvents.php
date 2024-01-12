<?php

declare(strict_types=1);

namespace App\Api;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Storage\Storage;

final class InfoEvents
{
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {

        $storage = Storage::connect();

        if (key_exists('key', $args) && $args['key']) {
            $res = $storage->get($args['key']);
        } else {
            $res = $storage->getAll();
        }

        $jsonResponse = $response->withHeader('Content-type', 'application/json');
        $jsonResponse->getBody()->write(json_encode($res));

        return $jsonResponse;
    }
}
