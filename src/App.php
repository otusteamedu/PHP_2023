<?php

declare(strict_types=1);

namespace Otus\App;

use Otus\App\EventSourcing\Application\Contract\EventGatewayInterface;
use Otus\App\EventSourcing\Application\Dto\ConditionDto;
use Otus\App\EventSourcing\Application\Dto\EventDto;
use Otus\App\EventSourcing\Application\UseCase\CreateEventUseCase;

final class App
{
    public function __construct(
        private readonly EventGatewayInterface $eventGateway
    ) {
    }

    public function run(): void
    {
        $eventDto = new EventDto(
            id: 1,
            name: 'Event name',
            priority: 1000,
            conditions: [
                new ConditionDto('param_1', 1),
            ]
        );

        (new CreateEventUseCase($this->eventGateway))->create($eventDto);
    }
}
