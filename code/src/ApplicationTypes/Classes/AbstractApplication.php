<?php

namespace GregoryKarman\ChatInUnixSocket\ApplicationTypes\Classes;

abstract class AbstractApplication
{
    protected string $socketFilePath;
    protected int $maxLength;

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        $this->socketFilePath = $this->getSocketFilePath();
        $this->maxLength = $this->getMaxLength();
    }

    abstract public function run(): void;


    protected function createSocket(): \Socket
    {
        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        return $socket;
    }
    /**
     * @throws \Exception
     */
    private function getSocketFilePath(): string
    {
        try {
            $configs = $this->getConfigs();
            return (string) $configs['path'];
        } catch (\Exception $exception) {
            throw new \Exception("Проверьте path в config.ini");
        }
    }

    private function getMaxLength(): int
    {
        try {
            $configs = $this->getConfigs();
            return (int) $configs['length'];
        } catch (\Exception $exception) {
            throw new \Exception("Проверьте length в config.ini");
        }
    }

    private function getConfigs(): array
    {
        $pathToConfigFile = (dirname(__DIR__)) . "/../configs/config.ini";
        return parse_ini_file($pathToConfigFile);
    }
}
