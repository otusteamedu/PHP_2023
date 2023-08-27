<?php

declare(strict_types=1);

namespace Ndybnov\Hw06\hw;

define('LN_END', '<br>');

class Output
{
    public static function lineEnd(): void
    {
        echo LN_END;
    }

    public static function show(string $string): void
    {
        echo $string;
    }
}
