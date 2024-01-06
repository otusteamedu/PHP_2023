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
        return $this->body->getValue();
    }
}
