<?php

declare(strict_types=1);

namespace Imitronov\Hw12\Application\UseCase\Event;

use Imitronov\Hw12\Application\Factory\ConditionFactory;
use Imitronov\Hw12\Application\Repository\EventRepository;
use Imitronov\Hw12\Domain\Entity\Event;

final class SearchEvents
{
    public function __construct(
        private readonly EventRepository $eventRepository,
        private readonly ConditionFactory $conditionFactory,
    ) {
    }

    /**
     * @return Event[]
     */
    public function handle(SearchEventsInput $input): array
    {
        return $this->eventRepository->allByConditions(
            array_map(
                fn ($conditionDto) => $this->conditionFactory->makeFromDto($conditionDto),
                $input->getConditions(),
            )
        );
    }
}
