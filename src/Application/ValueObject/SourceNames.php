<?php

namespace App\Application\ValueObject;

class SourceNames
{
    private array $names;

    public function __construct(array $names)
    {
        $this->names = $names;
    }

    public function getNames(): array
    {
        return $this->names;
    }
}