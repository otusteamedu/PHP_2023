<?php

declare(strict_types=1);

namespace Yevgen87\App;

use Exception;
use Yevgen87\App\Services\Server;
use Yevgen87\App\Services\Client;

class App
{
    public function run()
    {
        $config = require(__DIR__ . '/config/socket.php');

        $type = $_SERVER['argv'][1] ?? null;

        if ($type == 'server') {
            $app = new Server($config['host'], $config['port']);
            $app->run();
        }

        if ($type == 'client') {
            $app = new Client($config['host'], $config['port']);
            $app->run();
        }

        throw new Exception('Unknown type');
    }
}
