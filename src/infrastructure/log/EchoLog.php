<?php

namespace src\infrastructure\log;

class EchoLog implements LogInterface
{
    public function info(string $message): void
    {
        echo $message;
        echo PHP_EOL;
    }

    public function warning(string $message): void
    {
        echo 'WARNING: ' . $message;
        echo PHP_EOL;
    }

    public function error(string $message): void
    {
        echo 'ERROR: ' . $message;
        echo PHP_EOL;
    }
}
