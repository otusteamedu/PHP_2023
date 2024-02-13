<?php

declare(strict_types=1);

namespace src\Queue\Application\UseCase\Request;

class AddElementQueueRequest
{
    public function __construct(
        private string $body
    )
    {
    }

    public function getBody(): string
    {
        return $this->body;
    }
}
