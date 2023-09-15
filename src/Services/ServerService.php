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
            printf("New connection #%s from %s!\n", $res = $client->getResourceId(), $client->getLocalAddress());

            $client->on('data', function($client, $data) use(&$buffer) {
                printf("Received message=\"%s\"\n", $data);
            });
            $client->on('close', function() use($res) {
                printf("Closed connection #$res\n");
            });
        });
        $server->start();
        $this->loop->start();
    }

}