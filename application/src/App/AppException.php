<?php

declare(strict_types=1);

namespace Gesparo\HW\App;

class AppException extends \Exception
{
    private const PATH_HELPER_NOT_INITIALIZED = 1;
    private const NAVIGATION_FILE_NOT_EXISTS = 2;
    private const NAVIGATION_FILE_NOT_READABLE = 3;
    private const ENV_FILE_NOT_EXISTS = 4;
    private const ENV_FILE_NOT_READABLE = 5;
    private const PROVIDER_NOT_FOUND = 6;
    private const MODE_NOT_FOUND = 7;
    private const MESSAGE_HAS_STOP_WORDS = 8;
    private const PHONE_IS_BLOCKED = 9;

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

    public static function providerNotFound(string $provider): self
    {
        return new self("Provider not found: $provider", self::PROVIDER_NOT_FOUND);
    }

    public static function modeNotFound(string $mode): self
    {
        return new self("Mode not found: $mode", self::MODE_NOT_FOUND);
    }

    public static function messageHasStopWords(string $message, string $word): self
    {
        return new self("Message '$message' has stop words: $word", self::MESSAGE_HAS_STOP_WORDS);
    }

    public static function phoneIsBlocked(string $phone): self
    {
        return new self("Phone '$phone' is blocked", self::PHONE_IS_BLOCKED);
    }
}
