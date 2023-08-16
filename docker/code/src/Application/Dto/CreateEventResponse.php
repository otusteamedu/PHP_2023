<?php

namespace IilyukDmitryi\App\Application\Dto;

class CreateEventResponse
{
    public function __construct(protected int $cntAdd)
    {
    }
    
    /**
     * @return int
     */
    public function getCntAdd(): int
    {
        return $this->cntAdd;
    }
}
