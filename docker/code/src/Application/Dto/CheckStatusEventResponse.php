<?php

namespace IilyukDmitryi\App\Application\Dto;

class CheckStatusEventResponse
{
    /**
     * @param string $dateStart
     * @param string $dateEnd
     * @param string $email
     */
    public function __construct(protected readonly string $message)
    {
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}
