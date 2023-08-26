<?php

namespace Ndybnov\Hw05\hw;

class Validate
{
    public static function checkArgumentType(string $typeApp): bool
    {
        if (!in_array($typeApp, ['server', 'client'])) {
            throw new \RuntimeException('except `server` or `client` not other!');
        }
        return true;
    }

    public static function availableSocketFunctions(): bool
    {
        if (!\extension_loaded('sockets')) {
            throw new \RuntimeException('The sockets extension is not loaded!');
        }
        return true;
    }
}
