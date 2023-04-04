<?php

declare(strict_types=1);

namespace Vp\App\DTO;

class ParamsAdd
{
    private string $login;
    private string $email;

    public function __construct(string $login, string $email)
    {
        $this->login = $login;
        $this->email = $email;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
