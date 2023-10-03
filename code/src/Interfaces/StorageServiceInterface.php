<?php

namespace Eevstifeev\Hw12\Interfaces;

use Eevstifeev\Hw12\Models\Event;

interface StorageServiceInterface
{
    public function addEvent(array $data): Event;

    public function clearAllEvents(): bool;

    public function getEventByParams(array $params): ?Event;

    public function clearEvent(mixed $eventUuid): bool;
    public function getEventByUuid(string $uuid): ?Event;
}