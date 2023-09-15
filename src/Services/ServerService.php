<?php

namespace Rofflexor\Hw\Services;

use Kraken\Ipc\Socket\SocketInterface;
use Kraken\Ipc\Socket\SocketListener;
use Kraken\Loop\Loop;
use Kraken\Loop\Model\SelectLoop;
use Kraken\Throwable\Exception\Logic\InstantiationException;
use Rofflexor\Hw\Libs\Config;

class ServerService
{

    protected Loop $loop;

    public function __construct()
    {
        $this->loop = new Loop(new SelectLoop());
    }

    /**
     * @throws InstantiationException
     */
    public function start() {
        $server = new SocketListener('unix://'.(new Config())->getSocketPath(), $this->loop);
        $server->on('connect', function($server, SocketInterface $client) {
            $client->on('data', function($client, $data) use(&$buffer) {
                $client->write("Received message=$data\n");
            });
        });
        $this->loop->onStart(function() use($server) {
            $server->start();
        });
        $this->loop->start();
    }

}