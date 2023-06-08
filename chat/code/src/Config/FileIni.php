<?php

namespace IilyukDmitryi\App\Config;

class FileIni implements ConfigProvider
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
    public function getNameClassServerWorker(): string
    {
        return $this->config['server'];
    }

    /**
     * @return string
     */
    public function getNameClassClientWorker(): string
    {
        return $this->config['client'];
    }

    /**
     * @return string
     */
    public function getNameClassBehaviorProvider(): string
    {
        return $this->config['behavior_provider'];
    }
}
