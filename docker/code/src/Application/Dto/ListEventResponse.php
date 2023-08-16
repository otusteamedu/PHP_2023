<?php

namespace IilyukDmitryi\App\Application\Dto;

use IilyukDmitryi\App\Domain\Model\EventModel;

class ListEventResponse
{
    public function __construct(protected array $arrEventModel)
    {
    }
    
    /**
     * @return int
     */
    public function getEventList(): array
    {
        $arrEventList = [];
        /** @var EventModel $eventModel */
        foreach ($this->arrEventModel as $eventModel) {
            $arrEventList[] = $eventModel->toArray();
        }
        return $arrEventList;
    }
}
