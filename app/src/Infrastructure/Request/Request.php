<?php

namespace App\Infrastructure\Request;

class Request
{
    private string $requestJson;

    public function __construct(string $requestJson)
    {
        $this->requestJson = $requestJson;
    }

    public function toArray(): array
    {
        return json_decode($this->requestJson, true);
    }

    public function validate(): void
    {
        //TODO
    }
}
