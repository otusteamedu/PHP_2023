<?php

declare(strict_types=1);

namespace Otus\App\EventSystem;

use Otus\App\Entity\Condition;
use Otus\App\Entity\Event;
use Otus\App\EventProvider\EventProviderInterface;

final readonly class EventSystem
{
    public function __construct(
        private EventProviderInterface $eventProvider,
    ) {
    }

    public function process(): void
    {
        $this->clearStore();
        $this->createEvents();
        $this->showMostSuitableEvent();
    }

    private function createEvents(): void
    {
        $this->eventProvider->add(new Event(1, 'First event'), 3000, new Condition('param1', 1), new Condition('param2', 2));
        $this->eventProvider->add(new Event(2, 'Second event'), 2000, new Condition('param1', 2), new Condition('param2', 2));
        $this->eventProvider->add(new Event(3, 'Third event'), 1000, new Condition('param1', 1), new Condition('param2', 2));
    }

    private function showMostSuitableEvent(): void
    {
        $userParamRequest = [new Condition('param1', 1), new Condition('param2', 2)];
        $event = $this->eventProvider->mostSuitableEvent(...$userParamRequest);

        fwrite(STDOUT, print_r($event, true));
    }

    private function clearStore(): void
    {
        $this->eventProvider->clear();
    }
}
