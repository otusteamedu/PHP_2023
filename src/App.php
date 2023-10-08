<?php

declare(strict_types=1);

namespace App;

use Exception;

class App
{
    /**
     * @throws Exception
     */
    public function run(): void
    {
        global $argv;
        $config = parse_ini_file(__DIR__ . '/../config.ini', true);

        if ($argv[1] === 'server') {
            $server = new Server($config['socket']['path']);
            $server->listen();
        } elseif ($argv[1] === 'client') {
            $client = new Client($config['socket']['path']);
            $client->connect();
        } else {
            throw new Exception('Invalid argument. Use "server" or "client"');
        }
    }
}
