<?php

namespace IilyukDmitryi\App\Application\Dto;

class MessageSendRequest
{
    private string $body;

    public function __construct(string $body)
    {
        $this->body = $body;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }
}
