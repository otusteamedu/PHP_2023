<?php

namespace Gkarman\Redis\Dto;

class EventDto
{
    public string $code;
    public int $priority;

    public function __construct(array $data)
    {
        $this->code = $data['event']['code'];
        $this->priority = $data['priority'] ?? 0;
    }
}
