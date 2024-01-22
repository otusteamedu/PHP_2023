<?php

declare(strict_types=1);

namespace src\Application\Repository;

use src\Domain\Event;

interface RepositoryInterface
{
    public function addNewEvent(Event $event): void;

    public function clearAllEvent(): void;

    public function getByParameters(int $param1, int $param2): Event;
}
