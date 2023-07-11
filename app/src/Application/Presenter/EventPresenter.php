<?php

declare(strict_types=1);

namespace Imitronov\Hw12\Application\Presenter;

use Imitronov\Hw12\Application\ViewModel\EventViewModel;
use Imitronov\Hw12\Domain\Entity\Event;

final class EventPresenter
{
    public function __construct(
        private readonly ConditionsPresenter $conditionsPresenter,
        private readonly EventDataPresenter $eventDataPresenter,
    ) {
    }

    public function present(Event $event): EventViewModel
    {
        return new EventViewModel(
            $event->getPriority(),
            $this->conditionsPresenter->present($event->getConditions()),
            $this->eventDataPresenter->present($event->getData()),
        );
    }
}
