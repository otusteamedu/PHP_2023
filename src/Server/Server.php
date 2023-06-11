<?php

namespace App\Server;

use App\Transport\Socket\SocketInterface;

class Server
{
    private SocketInterface $transport;
    public function __construct(SocketInterface $transport) {
        $this->transport = $transport;
    }

    public function start(): void
    {
        $connect = $this->transport
            ->create(true)
            ->bind()
            ->listen(5)
            ->accept();
        while (true) {
            $res = $this->transport->recv($connect);

            if($res) {
                $this->transport->send($connect, "Reverse message: " . strrev($res));
            }
        }
    }
}