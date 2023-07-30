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

    public function getRadisHost(): string
    {
        return $this->config['radis_host'];
    }

    /**
     * @return string
     */
    public function getRadisPort(): string
    {
        return $this->config['radis_port'];
    }
}
