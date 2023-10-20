<?php

declare(strict_types=1);

namespace src\Application\Service;

use Symfony\Component\Uid\Ulid;

class UlidService
{
    public static function generate(): string
    {
        return Ulid::generate();
    }
}
