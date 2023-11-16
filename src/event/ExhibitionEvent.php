<?php

namespace src\event;

class ExhibitionEvent implements EventInterface
{
    private const TYPE = 'exhibition';

    public function getType(): string
    {
        return $this::TYPE;
    }
}
