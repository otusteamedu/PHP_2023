<?php

declare(strict_types=1);

namespace Gesparo\Homework;

class PathHelper
{
    private static ?self $instance = null;

    private function __construct(private readonly string $rootPath)
    {
    }

    /**
     * @throws AppException
     */
    public static function getInstance(): self
    {
        if (null === self::$instance) {
            throw AppException::pathHelperNotInitialized();
        }

        return self::$instance;
    }

    public static function init(string $rootPath): void
    {
        self::$instance = new self($rootPath);
    }

    public function getRootPath(): string
    {
        return $this->rootPath;
    }

    public function getEnvPath(): string
    {
        return $this->getRootPath();
    }
}