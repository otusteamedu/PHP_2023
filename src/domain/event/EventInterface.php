<?php

namespace src\domain\event;

interface EventInterface
{
    public function getType(): string;
}
