<?php

namespace IilyukDmitryi\App\Application\Dto;

class MessageReciveResponse
{
    public function __construct(protected string $body)
    {
    }

    /**
     * @return int
     */
    public function getBody(): string
    {
        return $this->body;
    }
}
