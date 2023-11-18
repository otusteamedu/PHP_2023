<?php

namespace src\domain\event;

class CompetitionEvent implements EventInterface
{
    private const TYPE = 'competition';

    public function getType(): string
    {
        return $this::TYPE;
    }
}
