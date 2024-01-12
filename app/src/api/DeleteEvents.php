<?php

declare(strict_types=1);

namespace App\Api;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Storage\Storage;

final class DeleteEvents
{
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {

        $storage = Storage::connect();
        $res = $storage->delete($args['key']);

        $jsonResponse = $response->withHeader('Content-type', 'application/json');
        if ($res) {
            $jsonResponse->getBody()->write('Данные успешно удалены!');
        } else {
            $jsonResponse->getBody()->write('Данные не найдены!');
        }

        return $jsonResponse;
    }
}
