<?php

declare(strict_types=1);

namespace Ndybnov\Hw06\external;

class ValidateDnsMx
{
    public static function check(string $email): bool
    {
        $parts = explode('@', $email);

        if (!isset($parts[1])) {
            return false;
        }

        return checkdnsrr($parts[1], 'MX');
    }
}
