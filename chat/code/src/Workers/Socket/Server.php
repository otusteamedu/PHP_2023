<?php

namespace IilyukDmitryi\App\Workers\Socket;

use Exception;

class Server extends Socket
{
    /**
     * @return void
     */
    public function run(): void
    {
        $this->serverTurnOn();
        $this->listenSocket();
    }

    protected function serverTurnOn(): void
    {
        $this->removeSocketFile();
        $this->createSocket();
        $this->createStream();
    }

    private function removeSocketFile(): void
    {
        if (file_exists(self::SOCKET_FILE)) {
            unlink(self::SOCKET_FILE);
        }
    }

    /**
     * @return void
     * @throws Exception
     */
    private function createSocket(): void
    {
        $this->socket = stream_socket_server(static::SOCKET_ADRESS . static::SOCKET_FILE, $errno, $errstr);
        if (!$this->socket) {
            throw new Exception("$errstr ($errno)");
        }
    }

    /**
     * @return void
     * @throws Exception
     */
    private function createStream(): void
    {
        $this->stream = stream_socket_accept($this->socket);
        if (!$this->stream) {
            throw new Exception("Error create SERVER stream");
        }
    }

    /**
     * @return void
     * @throws Exception
     */
    private function listenSocket(): void
    {
        echo '---=== Server running ===---' . PHP_EOL;
        while (true) {
            $messageClient = $this->getRemoteMessage();
            echo 'I have received that : ' . $messageClient . PHP_EOL;
            $this->sendMessage($this->getConfirmationMessage($messageClient));
            if ($this->isExitMessage($messageClient)) {
                echo 'Command received "' . static::MESSAGE_EXIT . '". Turn off the server' . PHP_EOL;
                $this->serverTurnOff();
                return;
            }
        }
    }

    protected function serverTurnOff(): void
    {
        $this->closeStream();
        $this->closeSocket();
    }
}
