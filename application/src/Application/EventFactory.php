<?php

declare(strict_types=1);

namespace Gesparo\HW\Application;

use Gesparo\HW\Domain\Entity\Event;
use Gesparo\HW\Domain\ValueObject\Condition;
use Gesparo\HW\Domain\ValueObject\Name;
use Gesparo\HW\Domain\ValueObject\Priority;

class EventFactory
{
    /**
     * @param string $name
     * @param int $priority
     * @param Condition[] $conditions
     * @return Event
     */
    public function create(string $name, int $priority, array $conditions): Event
    {
        return new Event(new Name($name), new Priority($priority), $conditions);
    }
}
