<?php


namespace IilyukDmitryi\App\Domain\Entity;

use IilyukDmitryi\App\Domain\ValueObject\Currency;

class UserPurchase
{
    private int $id = 0;
    private int $purchaseId = 0;
    private int $userId = 0;
    
    
    public function __construct()
    {
    }
    
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
    
    /**
     * @param int $id
     * @return UserPurchase
     */
    public function setId(int $id): UserPurchase
    {
        $this->id = $id;
        return $this;
    }
    
    /**
     * @return int
     */
    public function getPurchaseId(): int
    {
        return $this->purchaseId;
    }
    
    /**
     * @param int $purchaseId
     * @return UserPurchase
     */
    public function setPurchaseId(int $purchaseId): UserPurchase
    {
        $this->purchaseId = $purchaseId;
        return $this;
    }
    
    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }
    
    /**
     * @param int $userId
     * @return Purchase
     */
    public function setUserId(int $userId): UserPurchase
    {
        $this->userId = $userId;
        return $this;
    }
}