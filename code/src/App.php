<?php

namespace chat\src;

use Exception;

class App
{
    private array $runners;

    public function __construct()
    {
        $this->runners = [
            'server' => new ServerRunner(),
            'client' => new ClientRunner()
        ];
    }

    /**
     * @throws Exception
     */
    public function run(): void
    {
        if (!isset($_SERVER['argv'][1])) {
            throw new Exception('Empty command.');
        }
        $runner = $_SERVER['argv'][1];
        if (!isset($this->runners[$runner])) {
            throw new Exception('Unknown command.');
        }
        $this->setRunner($runner)->run();
    }

    private function setRunner($runner): Runner
    {
        return new $this->runners[$runner];
    }
}