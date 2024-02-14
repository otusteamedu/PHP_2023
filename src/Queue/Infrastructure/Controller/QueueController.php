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
    public function getFormSave(): string
    {
        return file_get_contents(__DIR__ . '/../../../../public/home.html');
    }

    public function save(): string
    {
        $useCase = new AddElementQueueUseCase(new ElementFactory(), new RedisElementRepository());
        return $useCase(new AddElementQueueRequest(json_encode($_POST)));
    }

    public function getFromCheck(): string
    {
        return file_get_contents(__DIR__ . '/../../../../public/check.html');
    }

    public function check(): string
    {
        $useCase = new CheckUseCase(new RedisElementRepository());
        return $useCase($_POST['uuid']);
    }
}
