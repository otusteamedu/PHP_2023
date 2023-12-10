<?php

namespace GregoryKarman\ChatInUnixSocket\ApplicationTypes\Classes;

class ClientApp extends AbstractApplication
{
    /**
     * @throws \Exception
     */
    public function run(): void
    {
        $chatStarted = true;
        while ($chatStarted) {
            $socket = $this->initSocket();
            $message = $this->getMessage();
            socket_write($socket, $message, strlen($message));
            socket_recv($socket, $serverMessage, $this->maxLength, 0);
            print("$serverMessage \n");
            if ($message == "exit\n") {
                $chatStarted = false;
            }
        }
    }

    private function initSocket(): \Socket
    {
        $socket = $this->createSocket();
        socket_connect($socket, $this->socketFilePath);
        return $socket;
    }

    private function getMessage(): string
    {
        $stdin = fopen("php://stdin", "r");
        print("Введите сообщение: \n");
        $message = fgets($stdin);
        fclose($stdin);
        return $message;
    }
}
