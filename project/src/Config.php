<?php

declare(strict_types=1);

namespace Vp\App;

class Config
{
    private const DEFAULT_LENGTH = 255;
    private const SOCKET_PATH = '/socket/server.sock';
    private static int $length;
    private static string $socketPath;

    public static function setConfig(array $config): void
    {
        self::$length = $config['length'] ?? self::DEFAULT_LENGTH;
        self::$socketPath = $config['socket_path'] ?? self::SOCKET_PATH;
    }

    public static function getLength(): int
    {
        return self::$length;
    }

    public static function getSocketPath(): string
    {
        return self::$socketPath;
    }

}
