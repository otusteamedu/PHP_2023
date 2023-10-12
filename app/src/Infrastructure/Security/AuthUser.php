<?php

namespace App\Infrastructure\Security;

use App\Domain\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;

class AuthUser implements UserInterface
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getRoles(): array
    {
        return $this->user->getRoles();
    }

    public function eraseCredentials(): void
    {
        // ничего не делаем
    }

    public function getUserIdentifier(): string
    {
        return $this->user->getId()->getValue();
    }
}
