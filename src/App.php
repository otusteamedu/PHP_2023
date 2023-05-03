<?php

namespace Yakovgulyuta\Hw7;

use Yakovgulyuta\Hw7\Chat\BackSocket;
use Yakovgulyuta\Hw7\Chat\FrontSocket;
use Yakovgulyuta\Hw7\Chat\SocketInstance;
use Yakovgulyuta\Hw7\Chat\Start;

class App
{
    /**
     * @var Start[] $runners
     */
    private array $runners;

    public function __construct()
    {
        $this->runners = [
            'server' => new BackSocket(),
            'client' => new FrontSocket(),
        ];
    }

    public function run(): void
    {
        $argv = $_SERVER['argv'];
        if (!isset($argv)) {
            throw new \Exception('Укажите аргумент для определения типа сервиса');
        }

        $runnerType = $argv[1];
        foreach ($this->runners as $type => $runner) {
            if ($type === $runnerType) {
                echo 'Start ' . $runnerType . PHP_EOL;
                foreach ($runner->start() as $message) {
                    echo $message;
                }
            }
        }
    }
}
