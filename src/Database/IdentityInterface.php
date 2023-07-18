<?php

declare(strict_types=1);

namespace Otus\App\Database;

interface IdentityInterface
{
    public function getId(): int|string;
}
