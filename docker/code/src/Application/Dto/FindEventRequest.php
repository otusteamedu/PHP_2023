<?php

namespace IilyukDmitryi\App\Application\Dto;

class FindEventRequest
{
    private array $params;
    
    /**
     * @param string $event
     * @param int    $priority
     * @param array  $params
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }
    
    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }
}
