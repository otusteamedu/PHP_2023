<?php

namespace App\Domain;

class ElementBody
{
    private string $val;
    private string $uuid;

    public function __construct(string $val)
    {
        $this->val = $val;
        $this->uuid = sprintf('%s-%s', time(), 'uuid');
    }

    public function getValue(): string
    {
        return $this->val;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }
}
