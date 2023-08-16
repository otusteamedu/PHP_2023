<?php

namespace IilyukDmitryi\App\Application\Dto;

class CreateEventRequest
{
    private string $event;
    private int $priority;
    private array $params;
    
    /**
     * @param string $event
     * @param int    $priority
     * @param array  $params
     */
    public function __construct(string $event, int $priority, array $params)
    {
        $this->event = $event;
        $this->priority = $priority;
        $this->params = $params;
    }
    
    /**
     * @return string
     */
    public function getEvent(): string
    {
        return $this->event;
    }
    
    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }
    
    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }
}
