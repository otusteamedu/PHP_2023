<?php

namespace IilyukDmitryi\App\Application\Dto;

use IilyukDmitryi\App\Domain\Model\EventModel;

class FindEventResponse
{
    public function __construct(protected ?EventModel $eventModel)
    {
    }
    
    /**
     * @return int
     */
    public function getEvent(): array
    {
        if ($this->eventModel) {
            return $this->eventModel->toArray();
        }
        return [];
    }
}
