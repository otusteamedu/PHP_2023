<?php

declare(strict_types=1);

namespace Gesparo\ES;

class PathHelper
{
    private static self $instance;
    private string $rootPath;

    private function __construct(string $rootPath)
    {
        $this->rootPath = $rootPath;
    }

    public static function initInstance(string $rootPath): void
    {
        if (!isset(self::$instance)) {
            self::$instance = new self($rootPath);
        }
    }

    public static function getInstance(): self
    {
        return self::$instance;
    }

    public function getRootPath(): string
    {
        return $this->rootPath;
    }

    public function getEnvPath(): string
    {
        return $this->rootPath;
    }
}
