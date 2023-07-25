<?php

namespace App\Services\Socket;

use Generator;

class ClientSocket extends ASocket
{
    public function handle(): Generator
    {
        $this->create()->connect();

        while (true) {
            $message = readline("Message: ");

            if (! $message) {
                continue;
            }

            $this->write($message);
            echo $this->read() . PHP_EOL;
        }
    }
}
