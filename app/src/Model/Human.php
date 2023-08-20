<?php

declare(strict_types=1);

namespace Neunet\App\Model;

class Human
{
    private ?int $id;
    private string $name;
    private string $phone;
    private int $animalId;

    public function __construct(int $id, string $name, string $phone, int $animalId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->phone = $phone;
        $this->animalId = $animalId;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
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
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return int
     */
    public function getAnimalId(): int
    {
        return $this->animalId;
    }

    /**
     * @param int $animalId
     */
    public function setAnimalId(int $animalId): void
    {
        $this->animalId = $animalId;
    }
}
