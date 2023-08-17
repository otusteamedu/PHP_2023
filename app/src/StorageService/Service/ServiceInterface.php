<?php

declare(strict_types=1);

namespace Neunet\App\StorageService\Service;

use Neunet\App\Models\Event;

interface ServiceInterface
{
    public function addEvent(Event $event): bool;

    public function clearAllEvents(): bool;

    public function getEvent(array $params): ?Event;
}
