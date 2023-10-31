<?php


namespace IilyukDmitryi\App\Application\Dto;

use IilyukDmitryi\App\Domain\ValueObject\Currency;

readonly class PurchaseRequestDto
{
    
    public function __construct(
        private string $name,
        private string $cost
    )
    {
    }
    
    public function getName(): string
    {
        return $this->name;
    }
    
    public function getCost(): string
    {
        return $this->cost;
    }
}