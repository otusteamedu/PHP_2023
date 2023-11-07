<?php

declare(strict_types=1);

namespace Gesparo\ES;

use Dotenv\Dotenv;

class EnvCreator
{
    private string $pathToEnvFile;

    public function __construct(string $pathToEnvFile)
    {
        $this->pathToEnvFile = $pathToEnvFile;
    }

    public function create(): EnvManager
    {
        $new = Dotenv::createImmutable($this->pathToEnvFile);
        $new->load();
        $new->required(EnvManager::getEnvParams())->notEmpty();

        return new EnvManager($_ENV);
    }
}
