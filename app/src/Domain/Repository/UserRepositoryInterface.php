<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\User;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Id;

interface UserRepositoryInterface
{
    public function nextId(): Id;

    public function firstByEmail(Email $email): ?User;

    public function firstById(Id $id): ?User;
}
