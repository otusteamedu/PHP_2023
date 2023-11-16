<?php

declare(strict_types=1);

namespace Gesparo\HW;

use Dotenv\Dotenv;

class EnvCreator
{
    private string $pathToEvnFile;

    public function __construct(string $pathToEvnFile)
    {
        $this->pathToEvnFile = $pathToEvnFile;
    }

    /**
     * @throws AppException
     */
    public function create(): EnvManager
    {
        $this->checkFile();

        $dotenv = Dotenv::createImmutable($this->pathToEvnFile);

        $dotenv->load();
        $dotenv->required(EnvManager::ENV_STORAGE)->allowedValues(['redis', 'mongo']);
        $dotenv->required(EnvManager::ENV_REDIS_HOST)->notEmpty();
        $dotenv->required(EnvManager::ENV_MONGO_HOST)->notEmpty();
        $dotenv->required(EnvManager::ENV_MONGO_DATABASE)->notEmpty();
        $dotenv->required(EnvManager::ENV_MONGO_USER)->notEmpty();
        $dotenv->required(EnvManager::ENV_MONGO_PASSWORD)->notEmpty();

        return new EnvManager();
    }

    /**
     * @throws AppException
     */
    private function checkFile(): void
    {
        if (!file_exists($this->pathToEvnFile)) {
            throw AppException::envFileNotExists($this->pathToEvnFile);
        }

        if (!is_readable($this->pathToEvnFile)) {
            throw AppException::envFileNotReadable($this->pathToEvnFile);
        }
    }
}
