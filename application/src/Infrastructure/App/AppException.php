<?php

declare(strict_types=1);

namespace Gesparo\HW\Infrastructure\App;

class AppException extends \Exception
{
    private const PATH_HELPER_NOT_INITIALIZED = 1;
    private const NAVIGATION_FILE_NOT_EXISTS = 2;
    private const NAVIGATION_FILE_NOT_READABLE = 3;
    private const ENV_FILE_NOT_EXISTS = 4;
    private const ENV_FILE_NOT_READABLE = 5;
    private const STORAGE_IS_INVALID = 6;

    public static function pathHelperNotInitialized(): self
    {
        return new self('PathHelper not initialized', self::PATH_HELPER_NOT_INITIALIZED);
    }

    public static function navigationFileNotExists(string $pathToFile): self
    {
        return new self("File with routes not found: $pathToFile", self::NAVIGATION_FILE_NOT_EXISTS);
    }

    public static function navigationFileNotReadable(string $pathToFile): self
    {
        return new self("File with routes not readable: $pathToFile", self::NAVIGATION_FILE_NOT_READABLE);
    }

    public static function envFileNotExists(string $pathToFile): self
    {
        return new self("File with env not found: $pathToFile", self::ENV_FILE_NOT_EXISTS);
    }

    public static function envFileNotReadable(string $pathToFile): self
    {
        return new self("File with env not readable: $pathToFile", self::ENV_FILE_NOT_READABLE);
    }

    public static function storageIsInvalid(string $storage): self
    {
        return new self("Storage is invalid: $storage", self::STORAGE_IS_INVALID);
    }
}
