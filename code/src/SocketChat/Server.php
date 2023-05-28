<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw6\SocketChat;



class Server
{
    public function run() {
        error_reporting(E_ALL);
        ob_implicit_flush();

        $sClientIpAddress = gethostbyname('client');
        $iClientPort = 10000;

        if (($obSocket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false) {
            throw new \Exception("Не удалось выполнить socket_create(): причина: " . socket_strerror(socket_last_error()) . "\n");
        }

        if (socket_bind($obSocket, $sClientIpAddress, $iClientPort) === false) {
            throw new \Exception("Не удалось выполнить socket_bind(): причина: " . socket_strerror(socket_last_error($obSocket)) . "\n");
        }

        if (socket_listen($obSocket, 5) === false) {
            throw new \Exception("Не удалось выполнить socket_listen(): причина: " . socket_strerror(socket_last_error($obSocket)) . "\n");
        }

        do {
            echo "socket_accept  11111\n\n";
            if (($obMessageSocket = socket_accept($obSocket)) === false) {
                throw new \Exception("Не удалось выполнить socket_accept(): причина: " . socket_strerror(socket_last_error($obSocket)) . "\n");
                break;
            }
            echo "socket_accept  22222\n\n";

            do {
                if (false === ($sClientMessage = socket_read($obMessageSocket, 2048, PHP_NORMAL_READ))) {
                    throw new \Exception("Не удалось выполнить socket_read(): причина: " . socket_strerror(socket_last_error($obMessageSocket)) . "\n");
                    break 2;
                }
                
                echo $sClientMessage;

                $sAnswerToClient = "Received " . strlen($sClientMessage) . " bytes";

                socket_write($obMessageSocket, $sAnswerToClient, strlen($sAnswerToClient));
            } while (true);
            socket_close($obMessageSocket);
        }  while (true);
        socket_close($obSocket);
    }
}
