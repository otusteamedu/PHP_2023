<?php

namespace IilyukDmitryi\App\Domain\ValueObject;

class Event
{
    protected string $value;
    
    public function __construct(string $value)
    {
        $this->value = htmlspecialchars(trim($value));
    }
    
    public function getValue(): string
    {
        return $this->value;
    }
}
