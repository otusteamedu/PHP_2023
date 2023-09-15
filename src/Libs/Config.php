<?php

namespace Rofflexor\Hw\Libs;

class Config
{
    protected array $config;

    protected string $configPath = __DIR__.'/../../config.ini';


    public function __construct()
    {
        if(!file_exists($this->configPath)) {
            throw new \InvalidArgumentException('Could not upload configuration');
        }
        $this->config =  parse_ini_file($this->configPath);
    }

    public function getSocketPath() {
        return array_key_exists('socket_path', $this->config)
            ? $this->config['socket_path']
            : throw new \InvalidArgumentException('Config socket_path must be defined');
    }
}