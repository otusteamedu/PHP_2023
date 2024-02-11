<?php
declare(strict_types=1);

namespace WorkingCode\Hw12\Service;

use WorkingCode\Hw12\DTO\Builder\EventDTOBuilder;
use WorkingCode\Hw12\DTO\EventDTO;

interface StorageInterface
{
    public function add(EventDTO $eventDTO): void;

    public function clearAll(): void;

    public function findOneByConditions(array $conditions, EventDTOBuilder $eventDTOBuilder): EventDTO;
}
