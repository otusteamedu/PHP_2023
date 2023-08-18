<?php declare(strict_types=1);

namespace Neunet\App\Model;

use Neunet\App\Database\Database;
use Neunet\App\DataMapper\HumanMapper;

class Animal
{
    private ?int $id;
    private string $type;
    private bool $male;
    private string $name;
    private int $age;
    private int $price;
    private ?Human $owner = null;

    public function __construct(int $id, string $type, bool $male, string $name, int $age, int $price)
    {
        $this->id = $id;
        $this->type = $type;
        $this->male = $male;
        $this->name = $name;
        $this->age = $age;
        $this->price = $price;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return bool
     */
    public function isMale(): bool
    {
        return $this->male;
    }

    /**
     * @param bool $male
     */
    public function setMale(bool $male): void
    {
        $this->male = $male;
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
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * @param int $age
     */
    public function setAge(int $age): void
    {
        $this->age = $age;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @param int $price
     */
    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    /**
     * Lazy load
     *
     * @return Human
     */
    public function getOwner(): Human
    {
        if ($this->owner === null) {
            $humanMapper = new HumanMapper((new Database())->connect());
            $human = $humanMapper->findByAnimalId($this->getId());
            $this->setOwner($human);
        }
        return $this->owner;
    }

    public function setOwner(Human $human): void
    {
        $this->owner = $human;
    }
}
