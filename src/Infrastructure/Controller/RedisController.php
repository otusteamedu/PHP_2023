<?php

declare(strict_types=1);

namespace src\Infrastructure\Controller;

use src\Application\Repository\RepositoryInterface;
use src\Application\UseCase\AddNewEventUseCase;
use src\Application\UseCase\ClearAllEventUseCase;
use src\Application\UseCase\GetByParametersUseCase;
use src\Application\UseCase\Request\AddNewEventRequest;
use src\Infrastructure\Repository\RedisRepository;

class RedisController
{
    public function add(array $argv): void
    {
        $useCase = new AddNewEventUseCase($this->getRepository());
        $useCase(
            new AddNewEventRequest(
                event: $argv[2],
                priority: (int)$argv[3],
                param1: isset($argv[4]) ? (int)$argv[4] : null,
                param2: isset($argv[5]) ? (int)$argv[5] : null,
            )
        );
    }

    public function clear(): void
    {
        $useCase = new ClearAllEventUseCase($this->getRepository());
        $useCase();
    }

    public function get(array $argv): void
    {
        $useCase = new GetByParametersUseCase($this->getRepository());
        $response = $useCase(
            isset($argv[2]) ? (int)$argv[2] : null,
            isset($argv[3]) ? (int)$argv[3] : null,
        );
        var_dump($response);
    }

    public function getRepository(): RepositoryInterface
    {
        return new RedisRepository();
    }

    public function fillWithBaseValuesFromJson(): void
    {
        $json = file_get_contents(__DIR__ . '/../docker/data/events.json');
        $events = json_decode($json, true);
        $useCase = new AddNewEventUseCase($this->getRepository());

        foreach ($events as $event) {
            $useCase(
                new AddNewEventRequest(
                    event: $event['event'],
                    priority: $event['priority'],
                    param1: isset($event['conditions']['param1']) ? (int)$event['conditions']['param1'] : null,
                    param2: isset($event['conditions']['param2']) ? (int)$event['conditions']['param2'] : null,
                )
            );
        }

        var_dump($events);
    }
}
