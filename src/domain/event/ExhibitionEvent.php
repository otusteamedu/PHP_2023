<?php

namespace src\domain\event;

class ExhibitionEvent implements EventInterface
{
    private const TYPE = 'exhibition';

    public function getType(): string
    {
        return $this::TYPE;
    }
}
