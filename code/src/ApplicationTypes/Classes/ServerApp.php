<?php

namespace GregoryKarman\ChatInUnixSocket\ApplicationTypes\Classes;

class ServerApp extends AbstractApplication
{
    public function run(): void
    {
        unlink($this->socketFilePath);
        $socket = $this->createSocket();
        socket_bind($socket, $this->socketFilePath);
        socket_listen($socket, 5);

        while (true) {
            $connect = socket_accept($socket);
            $clientMessage = null;
            socket_recv($connect, $clientMessage, $this->maxLength, 0);
            $clientMessageBytes = strlen(trim($clientMessage));
            $answerToClient = "Received {$clientMessageBytes} bytes";
            socket_write($connect, $answerToClient, strlen($answerToClient));
        }
    }
}
