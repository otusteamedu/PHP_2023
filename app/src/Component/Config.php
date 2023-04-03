<?php

declare(strict_types=1);

namespace Imitronov\Hw7\Component;

use Imitronov\Hw7\Exception\ConfigException;

final class Config
{
    private array $config;

    /**
     * @throws ConfigException
     */
    public function __construct()
    {
        $path = dirname(__DIR__, 2) . "/config/app.ini";

        if (!file_exists($path)) {
            throw new ConfigException('Config file not found.');
        }

        $this->config = parse_ini_file($path);
    }

    /**
     * @throws ConfigException
     */
    public function get(string $key): string
    {
        if (array_key_exists($key, $this->config)) {
            return $this->config[$key];
        }

        throw new ConfigException("Config value for key \"{$key}\" not set.");
    }
}
