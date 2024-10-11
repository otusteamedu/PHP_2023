<?php

namespace Alexgaliy\ConsoleChat;

use Exception;

class App
{
    public function run()
    {
        $command = $this->getCommand();
        return $command->run();
    }
    private function getCommand()
    {
        $argv = $_SERVER['argv'];
        if (count($argv) < 2) {
            throw new Exception('Передайте команду скрипту');
        }
        $class = '';
        switch ($argv[1]) {
            case 'server':
                $class = new Server(Utils::getPathToSocket());
                break;
            case 'client':
                $class = new Client(Utils::getPathToSocket());
                break;
            default:
                throw new Exception('Команда не найдена');
                break;
        }
        return $class;
    }
}
