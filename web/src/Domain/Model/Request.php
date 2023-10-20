<?php

namespace src\Domain\Model;

final class Request
{
    public function __construct(private readonly string $ulid, private readonly string $body)
    {
    }

    public function getUlid(): string
    {
        return $this->ulid;
    }

    public function getBody(): string
    {
        return $this->body;
    }
}
