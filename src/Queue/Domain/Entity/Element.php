<?php

declare(strict_types=1);

namespace src\Queue\Domain\Entity;

class Element
{
    private string $uuid;
    private string $body;
    private string $status;

    public function __construct(string $uuid, string $body, string $status)
    {
        $this->uuid = $uuid;
        $this->body = $body;
        $this->status = $status;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }
}
