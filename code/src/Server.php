<?php

namespace Otus\Hw;

class Server
{
    private \Socket $socket;
    private string $socketFile = 'volume/my_socket.sock';

    public function __construct()
    {
        unlink($this->socketFile);

        if (!($this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0))) {
            $errorcode = socket_last_error();
            $errormsg = socket_strerror($errorcode);

            throw new \Exception("Couldn't create socket: [$errorcode] $errormsg \n");
        }

        if (!socket_bind($this->socket, $this->socketFile)) {
            $errorcode = socket_last_error();
            $errormsg = socket_strerror($errorcode);

            throw new \Exception("Could not bind socket : [$errorcode] $errormsg \n");
        }
    }

    public function __destruct()
    {
        socket_close($this->socket);
    }

    public function run()
    {
        if (!socket_listen($this->socket, 10)) {
            $errorcode = socket_last_error();
            $errormsg = socket_strerror($errorcode);

            die("Could not listen on socket : [$errorcode] $errormsg \n");
        }

        echo "Waiting for incoming connections... \n";
        $clientSocket = socket_accept($this->socket);
        //display information about the client who is connected
        if (socket_getpeername($clientSocket, $address)) {
            echo "Client $address is now connected to us. \n";
        }

        while (true) {
            //read data from the incoming socket
            $input = socket_read($clientSocket, 1024000);
            if ($input == 'exit') {
                break;
            }
            echo "Received $input" . PHP_EOL;

            $size = strlen($input);
            $response = "Received $size bytes: $input";
            echo "Sending $response" . PHP_EOL;
            socket_write($clientSocket, $response);
            //socket_send ( $client , $response , strlen($response) , 0);
            $response = '';
        }

        echo "Connection closed \n";
    }
}
