<?php

namespace IilyukDmitryi\App\Domain\ValueObject;

class Priority
{
    protected int $value;
    
    public function __construct(int $value)
    {
        $this->value = $value;
    }
    
    public function getValue(): string
    {
        return $this->value;
    }
}
