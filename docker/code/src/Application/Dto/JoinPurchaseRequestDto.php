<?php


namespace IilyukDmitryi\App\Application\Dto;

class JoinPurchaseRequestDto
{
    
    public function __construct(
        private readonly int $purchaseId,
        private readonly int $userId,
    )
    {
    }
    
    public function getPurchaseId(): string
    {
        return $this->purchaseId;
    }
    public function getUserId(): int
    {
        return $this->userId;
    }
}