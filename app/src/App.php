<?php

declare(strict_types=1);

namespace Otus\SocketChat;

use Otus\SocketChat\Service\SocketService;
use Otus\SocketChat\SocketChat\{Client, Server};
use Otus\SocketChat\Utils\ConfigIni;
use RuntimeException;

class App
{
    private const SERVER = 'server';
    private const CLIENT = 'client';

    public function run(): void
    {
        if (!isset($_SERVER['argv'][0])) {
            throw new RuntimeException('undefined chat type');
        }
        $chatType = $_SERVER['argv'][1];

        $config = new ConfigIni();
        $socketService = new SocketService();

        $config->init();

        switch ($chatType) {
            case self::SERVER:
                (new Server($config, $socketService))->run();
                break;
            case self::CLIENT:
                (new Client($config, $socketService))->run();
                break;
            default:
                echo 'undefined chat type';
                exit(1);
        }
    }
}