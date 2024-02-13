<?php

declare(strict_types=1);

namespace src\Queue\Infrastructure\Console;

use src\Queue\Application\UseCase\ReadAllUseCase;
use src\Queue\Application\UseCase\SetStatusCompletedUseCase;
use src\Queue\Domain\Entity\Element;
use src\Queue\Infrastructure\Repository\RedisElementRepository;

class Console
{
    public function readAll(array $argv): void
    {
        $useCase = new ReadAllUseCase(new RedisElementRepository());
        $items = $useCase();

        /** @var Element $item */
        foreach ($items as $item) {
            echo "uuid: {$item->getUuid()} \nbody: {$item->getBody()} \nstatus: {$item->getStatus()} \n\n";
        }
    }

    public function setStatusCompletedStatus(array $argv): void
    {
        $useCase = new SetStatusCompletedUseCase(new RedisElementRepository());
        $useCase($argv[2]);
    }
}
