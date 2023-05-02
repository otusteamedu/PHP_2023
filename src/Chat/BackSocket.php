<?php

namespace Yakovgulyuta\Hw7\Chat;

class BackSocket extends SocketInstance
{

    public function start(): \Generator
    {
        while (true) {
            yield __METHOD__ . PHP_EOL;
            sleep(5);
        }
    }
}
