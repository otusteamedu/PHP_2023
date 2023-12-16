<?php

declare(strict_types=1);

namespace Gesparo\Homework;

use Dotenv\Dotenv;

class EnvManagerFactory
{
    public function __construct(private readonly PathHelper $pathHelper)
    {
    }

    /**
     * @throws AppException
     */
    public function create(): EnvManager
    {
        $this->validateEnvFile();

        $dotenv = Dotenv::createImmutable($this->pathHelper->getEnvPath());
        $dotenv->load();

        $dotenv->required(EnvManager::VARIABLES)->notEmpty();

        return new EnvManager();
    }

    /**
     * @throws AppException
     */
    private function validateEnvFile(): void
    {
        $envPath = $this->pathHelper->getEnvPath() . '.env';

        if (!file_exists($envPath)) {
            throw AppException::envFileNotFound($envPath);
        }

        if (!is_readable($envPath)) {
            throw AppException::envFileNotReadable($envPath);
        }
    }
}