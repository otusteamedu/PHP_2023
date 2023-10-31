<?php


namespace IilyukDmitryi\App\Domain\Entity;

use IilyukDmitryi\App\Domain\ValueObject\Currency;

class Transaction
{
    private int $id = 0;
    private int $eventId = 0;
    private int $fromUserId = 0;
    private int $toUserId = 0;
    private ?Currency $cost = null;
    
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'eventId' => $this->getEventId(),
            'fromUserId' => $this->getFromUserId(),
            'toUserId' => $this->getToUserId(),
            'cost' => $this->getCost()->format(true),
        ];
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
     * @return Transaction
     */
    public function setId(int $id): Transaction
    {
        $this->id = $id;
        return $this;
    }
    
    /**
     * @return int
     */
    public function getEventId(): int
    {
        return $this->eventId;
    }
    
    /**
     * @param int $eventId
     * @return Transaction
     */
    public function setEventId(int $eventId): Transaction
    {
        $this->eventId = $eventId;
        return $this;
    }
    
    /**
     * @return int
     */
    public function getFromUserId(): int
    {
        return $this->fromUserId;
    }
    
    /**
     * @param int $fromUserId
     * @return Transaction
     */
    public function setFromUserId(int $fromUserId): Transaction
    {
        $this->fromUserId = $fromUserId;
        return $this;
    }
    
    /**
     * @return int
     */
    public function getToUserId(): int
    {
        return $this->toUserId;
    }
    
    /**
     * @param int $toUserId
     * @return Transaction
     */
    public function setToUserId(int $toUserId): Transaction
    {
        $this->toUserId = $toUserId;
        return $this;
    }
    
    /**
     * @return ?Currency
     */
    public function getCost(): ?Currency
    {
        return $this->cost;
    }
    
    /**
     * @param Currency $cost
     * @return Transaction
     */
    public function setCost(Currency $cost): Transaction
    {
        $this->cost = $cost;
        return $this;
    }
    
    
}