<?php

declare(strict_types=1);

namespace Otus\App\EventSourcing\Domain\Repository;

use Otus\App\EventSourcing\Domain\Model\Event;

interface EventRepositoryInterface
{
    public function add(Event $event, int $priority, string $conditions);
}
