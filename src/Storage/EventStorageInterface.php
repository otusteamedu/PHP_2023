<?php

declare(strict_types=1);

namespace Ro\Php2023\Storage;

use Ro\Php2023\Entities\EventInterface;

interface EventStorageInterface
{
    public function addEvent(EventInterface $event);
    public function getAll(): array;
    public function getById(string $id): array;
    public function clearEvents();
    public function getMatchingEvent($requestedConditions);
}
