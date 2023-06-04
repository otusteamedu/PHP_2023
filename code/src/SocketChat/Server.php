<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw6\SocketChat;

class Server extends ChatEntity
{
    public function run()
    {
        ob_implicit_flush();

        $sFileName = "/data/mysite.local/public/ClientToServer.sock";

        if(file_exists($sFileName))
        {
            unlink($sFileName);
        }

        if (($obSocket = socket_create(AF_UNIX, SOCK_STREAM, 0)) === false) {
            $this->throwSocketException($obSocket, "socket_create");
        }

        if (socket_bind($obSocket, $sFileName) === false) {
            $this->throwSocketException($obSocket, "socket_bind");
        }

        if (socket_listen($obSocket) === false) {
            $this->throwSocketException($obSocket, "socket_listen");
        }

        do {
            if (($obMessageSocket = socket_accept($obSocket)) === false) {
                $this->throwSocketException($obSocket, "socket_accept");
            }

            do {
                if (($sClientMessage = socket_read($obMessageSocket, 2048)) === false) {
                    $this->throwSocketException($obMessageSocket, "socket_read");
                }

                echo $sClientMessage . "\n";

                $sAnswerToClient = "Received " . strlen($sClientMessage) . " bytes";
                if(socket_write($obMessageSocket, $sAnswerToClient, strlen($sAnswerToClient)) === false) {
                    $this->throwSocketException($obMessageSocket, "socket_write");
                }
            } while (true);
            socket_close($obMessageSocket);
        } while (true);
        socket_close($obSocket);

        unlink($sFileName);
    }
}
