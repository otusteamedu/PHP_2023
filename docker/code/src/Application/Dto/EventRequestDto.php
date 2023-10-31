<?php


namespace IilyukDmitryi\App\Application\Dto;

class EventRequestDto
{
    
    public function __construct(
        private readonly string $name,
        private readonly int $id,
    )
    {
    }
    
    public function getName(): string
    {
        return $this->name;
    }
    public function getId(): int
    {
        return $this->id;
    }
}