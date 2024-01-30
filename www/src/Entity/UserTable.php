<?php

declare(strict_types=1);

namespace Khalikovdn\Hw13\Entity;

class UserTable
{
    /**
     * @param int $id
     * @param string|null $name
     * @param string|null $lastName
     * @param string|null $secondName
     * @param string|null $gender
     * @param string|null $birthday
     */
    public function __construct(
        private int $id,
        private ?string $name,
        private ?string $lastName,
        private ?string $secondName,
        private ?string $gender,
        private ?string $birthday,
    ) {}

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return void
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $value
     * @return void
     */
    public function setName(?string $value): void
    {
        $this->name = $value;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string|null $value
     * @return void
     */
    public function setLastName(?string $value): void
    {
        $this->lastName = $value;
    }

    /**
     * @return string|null
     */
    public function getSecondName(): ?string
    {
        return $this->secondName;
    }

    /**
     * @param string|null $value
     * @return void
     */
    public function setSecondName(?string $value): void
    {
        $this->name = $value;
    }

    /**
     * @return string|null
     */
    public function getGender(): ?string
    {
        return $this->gender;
    }

    /**
     * @param string|null $value
     * @return void
     */
    public function setGender(?string $value): void
    {
        $this->name = $value;
    }

    /**
     * @return string|null
     */
    public function getBirthday(): ?string
    {
        return $this->birthday;
    }

    /**
     * @param string|null $value
     * @return void
     */
    public function setBirthday(?string $value): void
    {
        $this->name = $value;
    }
}
