<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Id;
use App\Domain\ValueObject\NotEmptyString;

/**
 * @final
 */
class User
{
    public function __construct(
        private Id $id,
        private Email $email,
        private NotEmptyString $passwordHash,
        private array $roles,
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

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function addRoles(array $roles): void
    {
        $this->roles = array_unique(array_merge($this->roles, $roles));
    }

    public function hasRole(string $role): bool
    {
        return in_array($role, $this->roles, true);
    }
}
