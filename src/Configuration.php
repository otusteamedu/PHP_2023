<?php
declare(strict_types=1);

namespace DanielPalm\Library;

class Configuration
{
    private string $basePath;

    public function __construct($basePath)
    {
        $this->basePath = $basePath;
    }

    public function loadEnv(): void
    {
        $envPath = $this->basePath . '/../.env';

        if (file_exists($envPath)) {
            $dotenv = \Dotenv\Dotenv::createImmutable($this->basePath . '/..');
            $dotenv->load();
        }
    }

    public function get($key, $default = null)
    {
        return $_ENV[$key] ?? $default;
    }
}
