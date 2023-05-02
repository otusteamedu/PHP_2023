<?php

namespace Yakovgulyuta\Hw7;

use Yakovgulyuta\Hw7\Chat\BackSocket;
use Yakovgulyuta\Hw7\Chat\FrontSocket;
use Yakovgulyuta\Hw7\Chat\SocketInstance;

class App
{

    /**
     * @var SocketInstance[] $runners
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
            throw new \Exception('Укажите аргумент для опредеелния типа сервиса');
        }
        foreach ($this->runners as $type => $runner) {
            $runnerType = $argv[1];
            if ($type === $runnerType) {
                foreach ($runner->start() as $message) {
                    echo $message;
                }
            }
        }
    }
}
