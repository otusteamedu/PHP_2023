<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Id;
use App\Domain\ValueObject\NotEmptyString;

class User
{
    public function __construct(
        private Id $id,
        private Email $email,
        private NotEmptyString $passwordHash,
    ) {
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPasswordHash(): NotEmptyString
    {
        return $this->passwordHash;
    }
}
