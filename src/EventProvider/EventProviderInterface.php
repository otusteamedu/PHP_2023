<?php

declare(strict_types=1);

namespace Otus\App\EventProvider;

use Otus\App\Entity\Condition;
use Otus\App\Entity\Event;

interface EventProviderInterface
{
    public function add(Event $event, int $priority, Condition ...$conditions): void;

    public function mostSuitableEvent(Condition ...$conditions): Event;

    public function clear(): void;
}
