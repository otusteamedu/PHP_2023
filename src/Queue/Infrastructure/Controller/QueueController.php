<?php

declare(strict_types=1);

namespace src\Queue\Infrastructure\Controller;

use src\Queue\Application\Factory\ElementFactory;
use src\Queue\Application\UseCase\AddElementQueueUseCase;
use src\Queue\Application\UseCase\CheckUseCase;
use src\Queue\Application\UseCase\Request\AddElementQueueRequest;
use src\Queue\Infrastructure\Repository\RedisElementRepository;

class QueueController
{
    public function save(): void
    {
        $useCase = new AddElementQueueUseCase(new ElementFactory(), new RedisElementRepository());
        $uuid = $useCase(new AddElementQueueRequest(json_encode($_POST)));
        echo $uuid;
    }

    public function check(): void
    {
        $useCase = new CheckUseCase(new RedisElementRepository());
        echo $useCase($_POST['uuid']);
    }
}
