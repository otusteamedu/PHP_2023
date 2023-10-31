<?php


namespace IilyukDmitryi\App\Application\Dto;

class PurchaseResponseDto
{
    private int $eventId;
    private string $purchaseName;
    private int $purchaseId;
    
    public function __construct(int $eventId, string $purchaseName, int $purchaseId)
    {
        $this->eventId = $eventId;
        $this->purchaseName = $purchaseName;
        $this->purchaseId = $purchaseId;
    }
    
    public function getEventId(): int
    {
        return $this->eventId;
    }
    
    public function getPurchaseName(): string
    {
        return $this->purchaseName;
    }
    
    public function getPurchaseId(): int
    {
        return $this->purchaseId;
    }

}