<?php
declare(strict_types=1);

namespace WorkingCode\Hw12\DTO\Builder;

use WorkingCode\Hw12\DTO\EventDTO;
use WorkingCode\Hw12\Helper\BuildHelper;

class EventDTOBuilder
{
    use BuildHelper;

    public function build(int $priority, string $conditions, string $events): EventDTO
    {
        return (new EventDTO())
            ->setPriority($priority)
            ->setConditions($this->getHashArrayFromString($conditions))
            ->setEvent($this->getHashArrayFromString($events));
    }

    public function buildFromArray(array $data): EventDTO
    {
        return (new EventDTO())
            ->setPriority($data['priority'])
            ->setConditions($data['conditions'])
            ->setEvent($data['event']);
    }
}
