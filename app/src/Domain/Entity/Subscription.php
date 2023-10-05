<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\Id;

class Subscription
{
    public function __construct(
        private Id $id,
        private Category $category,
        private User $user,
    ) {
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
