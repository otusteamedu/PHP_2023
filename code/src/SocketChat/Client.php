<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw6\SocketChat;

class Client extends ChatEntity
{
    public function run()
    {
        ob_implicit_flush();

        $sFileName = $this->getUnixSocketFilePath();

        if (($obSocket = socket_create(AF_UNIX, SOCK_STREAM, 0)) === false) {
            $this->throwSocketException($obSocket, "socket_create");
        }

        if (socket_connect($obSocket, $sFileName) === false) {
            $this->throwSocketException($obSocket, "socket_connect");
        }

        while ($sInputMessage = trim(fgets(STDIN))) {
            if (socket_write($obSocket, $sInputMessage, strlen($sInputMessage)) === false) {
                $this->throwSocketException($obSocket, "socket_write");
            }

            $sMessage = socket_read($obSocket, 2048);
            if ($sMessage !== false) {
                echo $sMessage . "\n";
            } else {
                $this->throwSocketException($obSocket, "socket_read");
            }
        }

        socket_close($obSocket);
    }
}
