<?php

namespace App\Application\DTO;

use App\Domain\ValueObject\Payload;
use App\Domain\ValueObject\Priority;
use App\Domain\ValueObject\Source;

class EventDataDTO
{
    public Priority $priority;
    public Source $source;
    public Payload $payload;

    public function __construct(Priority $priority, Source $source, Payload $payload)
    {
        $this->priority = $priority;
        $this->source = $source;
        $this->payload = $payload;
    }
}