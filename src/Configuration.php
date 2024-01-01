<?php

namespace DanielPalm\Library;

class Configuration
{
    private $basePath;

    public function __construct($basePath)
    {
        $this->basePath = $basePath;
    }

    public function loadEnv()
    {
        $envPath = $this->basePath . '/../.env';

        if (file_exists($envPath)) {
            $dotenv = \Dotenv\Dotenv::createImmutable($this->basePath . '/..');
            $dotenv->load();
        }
    }

    // You can add more methods to get specific config settings if needed
    public function get($key, $default = null)
    {
        return $_ENV[$key] ?? $default;
    }
}