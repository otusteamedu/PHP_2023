<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw6\SocketChat;


class Client
{
    public function run() {
        $iServerPort = 10001;
        $sServerIpAddress = gethostbyname('server');
        
        if (($obSocket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false) {
            throw new \Exception("Не удалось выполнить socket_create(): причина: " . socket_strerror(socket_last_error()) . "\n");
        }

        if (($result = socket_connect($obSocket, $sServerIpAddress, $iServerPort)) === false) {
            throw new \Exception("Не удалось выполнить socket_connect().\nПричина: ($result) " . socket_strerror(socket_last_error($obSocket)) . "\n");
        }

        while($sInputMessage = trim(fgets(STDIN)))
        {
            socket_write($obSocket, $sInputMessage, strlen($sInputMessage));
            echo socket_read($obSocket, 2048);
        }

        socket_close($obSocket);
    }
}
