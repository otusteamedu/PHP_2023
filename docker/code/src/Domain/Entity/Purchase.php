<?php


namespace IilyukDmitryi\App\Domain\Entity;

use IilyukDmitryi\App\Domain\ValueObject\Currency;

class Purchase
{
    private int $id = 0;
    private int $eventId = 0;
    private int $userId = 0;
    private string $name = "";
    private ?Currency $cost = null;
    
    /**
     * @var User[] $joinUsers
     */
    private array $joinUsers = [];
    
    
    public function toArray(): array
    {
        $res = [
            'id' => $this->id,
            'eventId' => $this->eventId,
            'userId' => $this->userId,
            'name' => $this->name,
            'cost' => $this->getCost()?->format(true)
        ];
        $res['joinUsers'] = [];
        if($this->joinUsers) {
            foreach ($this->joinUsers as $user) {
                $res['joinUsers'][] = $user->toArray();
            }
        }
        return $res;
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
     * @return Purchase
     */
    public function setId(int $id): Purchase
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
     * @return Purchase
     */
    public function setEventId(int $eventId): Purchase
    {
        $this->eventId = $eventId;
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
    public function setUserId(int $userId): Purchase
    {
        $this->userId = $userId;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    
    /**
     * @param string $name
     * @return Purchase
     */
    public function setName(string $name): Purchase
    {
        $this->name = $name;
        return $this;
    }
    
    /**
     * @return Currency
     */
    public function getCost(): Currency
    {
        return $this->cost;
    }
    
    /**
     * @param Currency $cost
     * @return Purchase
     */
    public function setCost(Currency $cost): Purchase
    {
        $this->cost = $cost;
        return $this;
    }
    
    /**
     * @return User[]
     */
    public function getJoinUsers(): array
    {
        return $this->joinUsers;
    }
    
    /**
     * @param int $userId
     * @return Purchase
     */
    public function setJoinUsers(array $users): Purchase
    {
        $this->joinUsers = $users;
        return $this;
    }
    
}
