<?php

namespace src\domain\entry;

class NotifyRow implements RowInterface
{
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getValue(): string
    {
        return $this->name;
    }
}
