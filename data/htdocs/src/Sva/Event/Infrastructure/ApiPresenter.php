<?php

namespace Sva\Event\Infrastructure;

use Sva\Common\Infrastructure\AbstractPresenter;
use Sva\Event\Domain\Event;

class ApiPresenter extends AbstractPresenter
{
    /**
     * @param Event $data
     * @return array
     */
    public function present(object $data): array
    {
        return [
            'priority' => $data->getPriority(),
            'conditions' => $data->getConditions(),
            'event' => $data->getEvent(),
        ];
    }
}
