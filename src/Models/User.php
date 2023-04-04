<?php

declare(strict_types=1);

namespace Twent\Hw13\Models;

use Twent\Hw13\Validation\DTO\InsertUserDto;
use Twent\Hw13\Validation\DTO\UserDto;

final class User
{
    public function __construct(
        private ?int $id,
        private string $firstname,
        private string $lastname,
        private string $email,
        private string $password,
        private ?int $age = null
    ) {
    }

    public static function fromDto(UserDto|InsertUserDto $dto): User
    {
        return new self(
            $dto->id ?? null,
            $dto->firstname,
            $dto->lastname,
            $dto->email,
            $dto->password,
            $dto->age
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'firstname' => $this->getFirstname(),
            'lastname' => $this->getLastname(),
            'email' => $this->getEmail(),
            'password' => $this->getPassword(),
            'age' => $this->getAge(),
        ];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setId(int $id): User
    {
        $this->id = $id;
        return $this;
    }

    public function setFirstname(string $firstname): User
    {
        $this->firstname = $firstname;
        return $this;
    }

    public function setLastname(string $lastname): User
    {
        $this->lastname = $lastname;
        return $this;
    }

    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    public function setPassword(string $password): User
    {
        $this->password = $password;
        return $this;
    }

    public function setAge(int $age): User
    {
        $this->age = $age;
        return $this;
    }
}
