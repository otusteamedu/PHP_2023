<?php

declare(strict_types=1);

namespace Api;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Storage\Storage;

final class UpdateEvents 
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
        
        if (!$storage->hasKey($key, $data['event'])) {
            $response->getBody()->write('События не добавлено!');
        } else {
            $storage->add($key, $data['priority'], $data['event']);
            $response->getBody()->write('Событие успешно обновленно!');
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
