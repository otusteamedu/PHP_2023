<?php

namespace App;

class ConfigSocketReader
{
    private array $config;

    public function __construct(string $pathToConfig)
    {
        $this->config = parse_ini_file($pathToConfig, true);
    }

    public function getPathToFile(): string
    {
        return $this->config['path_to_socket_file'];
    }

    public function getMaxBytes(): int
    {
        return intval($this->config['max_bytes']);
    }
}