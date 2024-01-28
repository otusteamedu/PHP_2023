<?php

namespace Sherweb;

use Exception;

class App
{
    private ?array $config;

    public function __construct()
    {
        $this->config = Config::load();
    }

    /**
     * Запускает процесс
     * @throws Exception
     */
    public function run(): void
    {
        $process = $this->getProcessClass();
        $process->run();
    }

    /**
     * Возвращает объект процесса
     * @throws Exception
     */
    private function getProcessClass()
    {
        $argv = $_SERVER['argv'];
        if (count($argv) < 2) {
            throw new Exception('Please specify the process name!');
        }

        switch ($argv[1]) {
            case 'server':
                return new Server($this->config);
            case 'client':
                return new Client($this->config);
            default:
                throw new Exception('Process not found!');
        }
    }
}