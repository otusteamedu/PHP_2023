<?php

declare(strict_types=1);

namespace Singurix\Chat;

class Config
{
    public array $config = [];
    public function __construct()
    {
        $configFile = '/app/config.ini';
        $this->config = parse_ini_file($configFile, true);
    }

    public function getSocketFile(): string
    {
        return $this->config['socket']['file'];
    }
}
