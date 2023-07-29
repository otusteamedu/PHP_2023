<?php

namespace IilyukDmitryi\App\Config;

class FileIni
{
    private const CONFIG_PATH = 'app.ini';
    private array $config = [];

    public function __construct()
    {
        $this->read();
    }

    private function read(): void
    {
        $this->config = parse_ini_file(self::CONFIG_PATH) ?: [];
    }

    /**
     * @return string
     */
    public function getNameStorage(): string
    {
        return $this->config['storage'];
    }

    /**
     * @return string
     */
    public function getElasticHost(): string
    {
        return $this->config['elastic_host'];
    }

    /**
     * @return string
     */
    public function getElasticUser(): string
    {
        return $this->config['elastic_user'];
    }

    /**
     * @return string
     */
    public function getElasticPass(): string
    {
        return $this->config['elastic_pass'];
    }

    /**
     * @return string
     */
    public function getElasticPort(): string
    {
        return $this->config['elastic_port'];
    }
}

