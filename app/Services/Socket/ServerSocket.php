<?php

namespace App\Services\Socket;

use Generator;

class ServerSocket extends ASocket
{
    public function handle(): Generator
    {
        $connect = $this->create(true)
                        ->bind()
                        ->listen(5)
                        ->accept();
        while (true) {
            $res = $this->recv($connect);

            if ($res) {
                $this->send($connect, "Reverse message: " . strrev($res));
            }
        }
    }
}
