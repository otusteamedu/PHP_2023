<?php

namespace Yakovgulyuta\Hw7\Chat;


class BackSocket  implements Start
{

    public function start(): \Generator
    {

        $instance = SocketInstance::create();

        $instance->bind();
        $instance->listen(5);

        $socket = $instance->accept();
        while (true) {
            $message = $socket->read();
            yield $message . PHP_EOL;
            $socket->write( "Received " . strlen($message) . " bytes");
        }
    }
}
