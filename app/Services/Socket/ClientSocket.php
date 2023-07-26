<?php

namespace App\Services\Socket;

use Generator;

class ClientSocket extends ASocket
{
    public function handle(): Generator
    {
        $this->create()->connect();

        $message = '';
        while ($message !== 'quit') {
            $message = readline("Message: ");

            if (! $message) {
                continue;
            }

            $this->write($message);
            yield $this->read() . PHP_EOL;
        }
    }
}
