<?php

namespace App\Domain\User\Domain\Model;

class User
{
    private $id;
    private $name;
    private $email;

    public function __construct(string $name, string $email)
    {
        $this->id = uniqid();
        $this->name = $name;
        $this->email = $email;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
