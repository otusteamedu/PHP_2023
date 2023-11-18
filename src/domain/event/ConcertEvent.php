<?php

namespace src\domain\event;

class ConcertEvent implements EventInterface
{
    private const TYPE = 'concert';

    public function getType(): string
    {
        return $this::TYPE;
    }
}
