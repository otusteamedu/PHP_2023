<?php

declare(strict_types=1);

namespace Gesparo\HW\Infrastructure\App;

class PathHelper
{
    private static PathHelper $instance;
    private string $rootPath;

    private function __construct(string $rootPath)
    {
        $this->rootPath = $rootPath;
    }

    public static function initInstance(string $rootPath): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new self($rootPath);
        }

        return self::$instance;
    }

    /**
     * @throws AppException
     */
    public static function getInstance(): self
    {
        if (!isset(self::$instance)) {
            throw AppException::pathHelperNotInitialized();
        }

        return self::$instance;
    }

    public function getNavigationFilePath(): string
    {
        return $this->rootPath . 'navigation.php';
    }

    public function getEnvFilePath(): string
    {
        return $this->rootPath;
    }
}
