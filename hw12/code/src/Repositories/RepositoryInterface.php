<?php

namespace Gkarman\Redis\Repositories;

use Gkarman\Redis\Dto\EventDto;

interface RepositoryInterface
{
    public function saveEvent(EventDto $eventDto): bool;

    public function clearEvents(): bool;
}
