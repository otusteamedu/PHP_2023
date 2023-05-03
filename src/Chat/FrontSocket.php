<?php

namespace Yakovgulyuta\Hw7\Chat;

class FrontSocket implements Start
{

    public function start(): \Generator
    {

        $instance = SocketInstance::create();
        $instance->connect();

        while (true) {
            $message = fgets(STDIN);
            $instance->write($message);
            $response = $instance->read();
            yield $response . PHP_EOL;
        }
    }
}
