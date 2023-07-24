<?php

namespace Otus\Hw;

class Client
{
    private \Socket $socket;
    private string $socketFile = 'volume/my_socket.sock';

    public function __construct()
    {
        if (!($this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0))) {
            $errorcode = socket_last_error();
            $errormsg = socket_strerror($errorcode);

            throw new \Exception("Couldn't create socket: [$errorcode] $errormsg");
        }

        if (!socket_connect($this->socket, $this->socketFile)) {
            $errorcode = socket_last_error();
            $errormsg = socket_strerror($errorcode);

            throw new \Exception("Could not connect: [$errorcode] $errormsg");
        }
    }

    public function __destruct()
    {
        socket_close($this->socket);
    }

    public function run(): void
    {
        echo "Type and enter to start messaging... \n";
        while (($line = fgets(STDIN)) !== false) {
            if (str_replace(PHP_EOL, '', $line) == 'exit') {
                $this->sendMessage('exit');
                exit('Quitting' . PHP_EOL);
            }
            $this->sendMessage($line);
            echo $this->receiveMessage();
        }
    }

    private function sendMessage(string $message): false|int
    {
        if (! $res = socket_send($this->socket, $message, strlen($message), 0)) {
            $errorcode = socket_last_error();
            $errormsg = socket_strerror($errorcode);

            throw new \Exception("Could not send data: [$errorcode] $errormsg");
        }
        return $res;
    }

    private function receiveMessage(): string
    {
        if (!$input = socket_read($this->socket, 1024)) {
            $errorcode = socket_last_error();
            $errormsg = socket_strerror($errorcode);

            throw new \Exception("Could not receive data: [$errorcode] $errormsg \n");
        }

        return $input;
    }
}
