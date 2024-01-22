<?php

declare(strict_types=1);

namespace App;

use src\Application\Repository\RepositoryInterface;
use src\Application\UseCase\AddNewEventUseCase;
use src\Application\UseCase\ClearAllEventUseCase;
use src\Application\UseCase\GetByParametersUseCase;
use src\Application\UseCase\Request\AddNewEventRequest;
use src\Infrastructure\Repository\RedisRepository;

class App
{
    public function run(array $argv): void
    {
        match ($argv[1]) {
            'add' => $this->add($argv),
            'clear' => $this->clear(),
            'get' => $this->get($argv)
        };
    }

    private function add(array $argv): void
    {
        $useCase = new AddNewEventUseCase($this->getRepository());
        $useCase(
            new AddNewEventRequest(
                priority: (int)$argv[2], param1: (int)$argv[3], param2: (int)$argv[4], event: $argv[5]
            )
        );
    }

    private function clear(): void
    {
        $useCase = new ClearAllEventUseCase($this->getRepository());
        $useCase();
    }

    private function get(array $argv): void
    {
        $useCase = new GetByParametersUseCase($this->getRepository());
        $response = $useCase($argv[2], $argv[3]);
        var_dump($response);
    }

    private function getRepository(): RepositoryInterface
    {
        return new RedisRepository();
    }
}
