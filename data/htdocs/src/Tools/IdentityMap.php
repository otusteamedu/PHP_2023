<?php

namespace Tools;

abstract class IdentityMap
{
    private static array $instances = [];

    public static function set(string $key, mixed $instance): void
    {
        self::$instances[$key] = $instance;
    }

    public static function get(string $key): mixed
    {
        return self::$instances[$key] ?? null;
    }

    public static function has(string $key): bool
    {
        return isset(self::$instances[$key]);
    }

    public static function remove(string $key): void
    {
        unset(self::$instances[$key]);
    }

    public static function clear(): void
    {
        self::$instances = [];
    }

    public static function getAll(): array
    {
        return self::$instances;
    }

    public static function setAll(array $instances): void
    {
        self::$instances = $instances;
    }

    public static function merge(array $instances): void
    {
        self::$instances = array_merge(self::$instances, $instances);
    }
}
