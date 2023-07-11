<?php

declare(strict_types=1);

namespace Imitronov\Hw12\Application\Presenter;

use Imitronov\Hw12\Application\ViewModel\EventDataViewModel;
use Imitronov\Hw12\Domain\ValueObject\EventData;

final class EventDataPresenter
{
    public function __construct(
        private readonly DateTimePresenter $dateTimePresenter,
    ) {
    }

    public function present(EventData $eventData): EventDataViewModel
    {
        return new EventDataViewModel(
            $eventData->getType(),
            $eventData->getName(),
            $this->dateTimePresenter->present($eventData->getDateTime()),
        );
    }
}
