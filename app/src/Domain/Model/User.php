<?php

declare(strict_types=1);

namespace App\Domain\Model;

use App\Domain\ValueObject\Login;
use App\Domain\ValueObject\Password;

class User
{
    private int $id;
    private Login $login;
    private Password $password;

    public function __construct(Login $login, Password $password)
    {
        $this->login = $login;
        $this->password = $password;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Login
     */
    public function getLogin(): Login
    {
        return $this->login;
    }

    /**
     * @return Password
     */
    public function getPassword(): Password
    {
        return $this->password;
    }
}
