<?php

declare(strict_types=1);

namespace App\Api;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Storage\Storage;

final class CreateEvents
{
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {

        $data = $request->getParsedBody();
        $validate = $this->validateRequest($data);
        if (!$validate['status']) {
            $errResponse = $response->withStatus(400);
            $errResponse->getBody()->write($validate['message']);
            return $errResponse;
        }

        $storage = Storage::connect();

        $key = $storage->getKey($data['conditions']);

        if ($storage->hasKey($key, $data['event'])) {
            $response->getBody()->write('События уже добавлено!');
        } else {
            $res = $storage->add($key, $data['priority'], $data['event']);
            if ($res > 0) {
                $response->getBody()->write('Событие успешно добавлено!');
            }
        }
        return $response;
    }

    private function validateRequest($data)
    {
        $status = true;
        $message = null;

        if (!key_exists('priority', $data) || !$data['priority']) {
            $status = false;
            $message = 'Укажите приоритет!';
        }
        if (!key_exists('conditions', $data) || !$data['conditions']) {
            $status = false;
            $message = 'Укажите условия!';
        }
        if (!key_exists('event', $data) || !$data['event']) {
            $status = false;
            $message = 'Укажите событие!';
        }
        return [
            'status' => $status,
            'message' => $message
        ];
    }
}
