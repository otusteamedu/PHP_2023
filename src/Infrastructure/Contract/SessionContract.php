<?php

declare(strict_types=1);

namespace Twent\BracketsValidator\Infrastructure\Contract;

interface SessionContract
{
    public static function set(string $key, string $value): void;
    public static function get(string $key): ?string;
    public static function remove(string $key): void;
}
