<?php

declare(strict_types=1);

namespace Gesparo\Homework\Application;

use Gesparo\Homework\AppException;

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

    public function getRoutesPath(): string
    {
        return $this->getRootPath() . '/routes.php';
    }

    public function getControllersPath(): string
    {
        return $this->getRootPath() . 'src/Infrastructure/Controller';
    }

    public function getResponsesPath(): string
    {
        return $this->getRootPath() . 'src/Application/Response';
    }

    public function getRequestsPath(): string
    {
        return $this->getRootPath() . 'src/Application/Request';
    }
}
