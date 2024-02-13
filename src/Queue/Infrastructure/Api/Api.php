<?php

declare(strict_types=1);

namespace src\Queue\Infrastructure\Api;

use src\Queue\Application\Factory\ElementFactory;
use src\Queue\Application\UseCase\AddElementQueueUseCase;
use src\Queue\Application\UseCase\CheckUseCase;
use src\Queue\Application\UseCase\Request\AddElementQueueRequest;
use src\Queue\Infrastructure\Repository\RedisElementRepository;

class Api
{
    public function home(): void
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $useCase = new AddElementQueueUseCase(new ElementFactory(), new RedisElementRepository());
        $uuid = $useCase(new AddElementQueueRequest(json_encode($request)));
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([$uuid]);
    }

    public function check(): void
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $useCase = new CheckUseCase(new RedisElementRepository());

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([$useCase($request['uuid'])]);
    }
}
