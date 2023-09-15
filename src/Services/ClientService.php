<?php

namespace Rofflexor\Hw\Services;

use Kraken\Ipc\Socket\Socket;
use Kraken\Loop\Loop;
use Kraken\Loop\Model\SelectLoop;
use Kraken\Throwable\Exception\Logic\InstantiationException;
use Rofflexor\Hw\Libs\Config;

class ClientService
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
        $socket = new Socket('unix://'.(new Config())->getSocketPath(), $this->loop);

        $socket->on('data', function ($socket, $data) {
            printf("%s\n", $data);
        });
        $this->loop->addPeriodicTimer(1, function() use($socket) {
            $input = rtrim(fgets(STDIN));
            if(!empty($input)) {
                $socket->write($input);
                $socket->read();
            }
        });

        $this->loop->start();
    }

}