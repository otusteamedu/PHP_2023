<?php

namespace IilyukDmitryi\App\Application\Dto;

class CheckStatusEventRequest
{
    /**
     * @param string $dateStart
     * @param string $dateEnd
     * @param string $email
     */
    public function __construct(protected readonly string $uuid)
    {
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }
}
