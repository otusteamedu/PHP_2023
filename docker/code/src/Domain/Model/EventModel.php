<?php

namespace IilyukDmitryi\App\Domain\Model;

use IilyukDmitryi\App\Domain\ValueObject\Event;
use IilyukDmitryi\App\Domain\ValueObject\Params;
use IilyukDmitryi\App\Domain\ValueObject\Priority;

class EventModel
{
    private Event $event;
    private Priority $priority;
    private Params $params;
    
    /**
     * @param Event    $event
     * @param Priority $priority
     * @param Params   $params
     */
    public function __construct(Event $event, Priority $priority, Params $params)
    {
        $this->event = $event;
        $this->priority = $priority;
        $this->params = $params;
    }
    
    /**
     * @return Event
     */
    public function getEvent(): Event
    {
        return $this->event;
    }
    
    /**
     * @return Priority
     */
    public function getPriority(): Priority
    {
        return $this->priority;
    }
    
    /**
     * @return Params
     */
    public function getParams(): Params
    {
        return $this->params;
    }
    
    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'event' => $this->event->getValue(),
            'priority' => $this->priority->getValue(),
            'params' => $this->params->getValue(),
        ];
    }
}
