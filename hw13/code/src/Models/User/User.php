<?php

namespace Gkarman\Datamaper\Models\User;

class User
{
    private int $id;
    private string $email;
    private string $firstName;
    private string $lastName;

    public function __construct(array $args)
    {
        $this->id = $args['id'];
        $this->email = $args['email'];
        $this->firstName = $args['first_name'];
        $this->lastName = $args['last_name'];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function fullUserInfo(): string
    {
        return "{$this->id} {$this->email} {$this->firstName} {$this->lastName}";
    }
}
