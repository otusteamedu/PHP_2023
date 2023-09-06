<?php

namespace Root\Www;

use Root\Www\Base;
use Root\Www\Socket;
use Root\Www\Helper;
use Exception;

class Client extends Base
{
    public function run()
    {
        while ($line = fgets(STDIN)) {
            $this->sendMessage($line);
        }
    }

    private function sendMessage($message)
    {
        $socket = new Socket(Helper::conf('PATH_CLIENT_SOCKET_FILE'));
        if (!$socket->bind()) {
            throw new Exception('Unable to bind to files!');
        }
        $bytes_sent = $socket->sendMessage($message, Helper::conf('PATH_SERVER_SOCKET_FILE'));
        if ($bytes_sent == -1) {
            throw new Exception('An error occured while sending to the socket!');
        }
        if (!$socket->setBlock()) {
            throw new Exception('Unable to set blocking mode for socket!');
        }
        $data = $socket->getMessage();
        if ($data['bytes_received'] == -1) {
            throw new Exception('An error occured while receiving from the socket!');
        }
        fwrite(STDOUT, $data['buf'] . PHP_EOL);
        if (!$socket->setNonBlock()) {
            throw new Exception('Unable to set nonblocking mode for socket!');
        }
    }
}
