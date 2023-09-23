<?php

declare(strict_types=1);

namespace App\Shared\Domain\Service;

use Symfony\Component\Uid\Ulid;

class UlidService
{
    public static function generate(): string
    {
        return Ulid::generate();
    }
}
