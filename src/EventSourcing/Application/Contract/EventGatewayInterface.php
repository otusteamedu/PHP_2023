<?php

declare(strict_types=1);

namespace Otus\App\EventSourcing\Application\Contract;

use Otus\App\EventSourcing\Domain\Model\Condition;
use Otus\App\EventSourcing\Domain\Model\Event;

interface EventGatewayInterface
{
    /**
     * @param Condition[] $conditions
     */
    public function add(Event $event, int $priority, array $conditions): void;
}
