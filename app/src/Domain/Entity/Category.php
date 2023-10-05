<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\Id;
use App\Domain\ValueObject\NotEmptyString;

class Category
{
    public function __construct(
        private Id $id,
        private NotEmptyString $name,
    ) {
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getName(): NotEmptyString
    {
        return $this->name;
    }

    public function setName(NotEmptyString $name): void
    {
        $this->name = $name;
    }
}
