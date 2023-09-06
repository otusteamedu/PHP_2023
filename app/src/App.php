<?php

namespace Root\Www;

use Root\Www\Helper;
use Root\Www\Client;
use Root\Www\Server;
use Exception;

class App
{
    public function run()
    {
        Helper::getConfig();
        $process = $this->getProcessClass();
        $process->run();
    }

    private function getProcessClass()
    {
        $argv = $_SERVER['argv'];
        if (count($argv) < 2) {
            throw new Exception('Please specify the process name!');
        }
        $class = '';
        switch ($argv[1]) {
            case 'server':
                $class = new Server();
            break;
            case 'client':
                $class = new Client();
            break;
            default:
                throw new Exception('Process not found!');
            break;
        }
        return $class;
    }
}
