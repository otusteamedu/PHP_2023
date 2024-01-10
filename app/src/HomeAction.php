<?php

declare(strict_types=1);

namespace App;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Storage\Storage;

final class HomeAction
{
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        $data = (array)$request->getQueryParams();

        $storage = Storage::connect();
        $key = $storage->getKey($data);
       
        $events = $storage->get($key);
        if ($events) {
            $response->getBody()->write("Вам доступно событие: " . array_key_first($events));
        } else {
            $response->getBody()->write("Нет подходящих событий.");
        }
    
        return $response;
    }
}
