<?php

namespace IilyukDmitryi\App\Infrastructure\Config;

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
    
    public function getMysqlHost(): string
    {
        return $this->config['mysql_host'];
    }
    
    /**
     * @return string
     */
    public function getMysqlUser(): string
    {
        return $this->config['mysql_user'];
    }
    
    /**
     * @return string
     */
    public function getMysqlPass(): string
    {
        return $this->config['mysql_pass'];
    }
    
    /**
     * @return string
     */
    public function getMysqlDbName(): string
    {
        return $this->config['mysql_dbname'];
    }
}
