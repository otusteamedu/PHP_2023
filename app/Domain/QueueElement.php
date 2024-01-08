<?php

namespace App\Domain;

class QueueElement
{
    private ElementBody $body;

    public function __construct(
        string $body
    ) {
        $this->body = new ElementBody($body);
    }

    public function getBodyValue(): string
    {
        $value = $this->body->getValue();
        $decoded = json_decode($value, true);
        $decoded['uuid'] = $decoded['uuid'] ?? $this->getUuid();
        $encoded = json_encode($decoded);

        return $encoded;
    }

    public function getUuid(): string
    {
        $value = $this->body->getValue();
        $decoded = json_decode($value, true);
        $uuid = $decoded['uuid'] ?? $this->body->getUuid();

        return $uuid;
    }
}
