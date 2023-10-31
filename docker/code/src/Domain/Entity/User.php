<?php


namespace IilyukDmitryi\App\Domain\Entity;

use IilyukDmitryi\App\Infrastructure\Storage\Mysql\Repository\IdentityMap;

class User
{
    private string $name = "";
    private int $id = 0;
    
    private static IdentityMap $identityMap;
    
    public function __construct(
    ) {
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
     * @return User
     */
    public function setName(string $name): User
    {
        $this->name = $name;
        return $this;
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
     * @return User
     */
    public function setId(int $id): User
    {
        $this->id = $id;
        return $this;
    }
    
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'id' => $this->id
        ];
    }
}