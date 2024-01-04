<?php
declare(strict_types=1);

namespace Vasilaki;

class Config
{
    private $config;

    public function __construct($configFile)
    {
        $this->config = parse_ini_file($configFile, true);
    }

    public function get($section, $key)
    {
        return $this->config[$section][$key] ?? null;
    }
}