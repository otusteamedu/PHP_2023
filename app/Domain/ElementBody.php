<?php

namespace App\Domain;

class ElementBody
{
    private string $val;

    public function __construct(string $val)
    {
        $this->val = $val;
    }

    public function getValue(): string
    {
        return $this->val;
    }
}
