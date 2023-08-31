<?php

declare(strict_types=1);

namespace App\Music\Domain\Entity;

use App\Shared\Domain\Service\UlidService;

class User
{
    private string $id;
    private string $email;
    private string $password;

    public function __construct(string $email, string $password)
    {
        $this->id = UlidService::generate();
        $this->email = $email;
        $this->password = $password;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
