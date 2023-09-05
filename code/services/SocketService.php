<?php

/**
 * Класс для работы с сокетами
 * php version 8.2.8
 *
 * @category ItIsDepricated
 * @package  AmedvedevPHP2023Otus
 * @author   Alex 150Rus <alex150rus@outlook.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @Version  GIT: 1.0.0
 * @link     http://github.com/Alex150Rus My_GIT_profile
 */

declare(strict_types=1);

namespace Amedvedev\code\services;

use Amedvedev\code\config\Config;
use Socket;

class SocketService
{
    private Socket $socket;
    private string $chatSocket;
    private int $chatPort;

    public function __construct()
    {
        $this->chatSocket = Config::get('chat_socket');
        $this->chatPort = (int)Config::get('chat_port');
    }

    /**
     * @return void
     * @throws \Exception
     */
    private function server()
    {
        if (!($this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0))) {
            $errorcode = socket_last_error();
            $errormsg = socket_strerror($errorcode);

            throw new \Exception("Couldn't create socket: [$errorcode] $errormsg \n");
        }

        if (file_exists($this->chatSocket)) {
            unlink($this->chatSocket);
        }

        //f you want to reuse address and port, and get rid of error: unable to bind, address already in use
        if (!socket_set_option($this->socket, SOL_SOCKET, SO_REUSEADDR, 1)) {
            throw new \Exception(socket_strerror(socket_last_error($this->socket)));
        }

        echo "Socket created" . PHP_EOL;

        // Bind the source address
        if (!socket_bind($this->socket, $this->chatSocket, $this->chatPort)) {
            $errorcode = socket_last_error();
            $errormsg = socket_strerror($errorcode);

            throw new \Exception("Could not bind socket : [$errorcode] $errormsg \n");
        }

        echo "Socket bind OK \n";

        if (!socket_listen($this->socket, 10)) {
            $errorcode = socket_last_error();
            $errormsg = socket_strerror($errorcode);

            throw new \Exception("Could not listen on socket : [$errorcode] $errormsg \n");
        }

        echo "Socket listen OK \n";

        echo "Waiting for incoming connections... \n";

        //start loop to listen for incoming connections
        $demon = true;
        while ($demon) {
            //Accept incoming connection - This is a blocking call
            $client = socket_accept($this->socket);

            //display information about the client who is connected
            if (socket_getpeername($client, $address, $port)) {
                echo "Client $address : $port is now connected to us." . PHP_EOL;
            }

            //read data from the incoming socket
            $input = socket_read($client, 1024000);

            $response = "OK .. $input" . PHP_EOL;

            if ($input === 'exit') {
                $demon = false;
            }
            // Display output  back to client
            socket_write($client, $response);
            socket_close($client);
        }
        socket_close($this->socket);
    }

    /**
     * @return void
     * @throws \Exception
     */
    private function client(): void
    {
        $demon = true;
        while ($demon) {
            if (!($this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0))) {
                $errorcode = socket_last_error();
                $errormsg = socket_strerror($errorcode);

                throw new \Exception("Couldn't create socket: [$errorcode] $errormsg \n");
            }

            //Connect socket to remote server
            if (!socket_connect($this->socket, $this->chatSocket, $this->chatPort)) {
                $errorcode = socket_last_error();
                $errormsg = socket_strerror($errorcode);

                throw new \Exception("Could not connect: [$errorcode] $errormsg \n");
            }

            $demon = true;
            $message = readline("Enter message: ");

            //Send the message to the server
            if (!socket_send($this->socket, $message, strlen($message), 0)) {
                $errorcode = socket_last_error();
                $errormsg = socket_strerror($errorcode);

                throw new \Exception("Could not send data: [$errorcode] $errormsg \n");
            }

            echo "Message send successfully \n";

            //Now receive reply from server
            if (socket_recv($this->socket, $buf, 2045, MSG_WAITALL) === false) {
                $errorcode = socket_last_error();
                $errormsg = socket_strerror($errorcode);

                throw new \Exception("Could not receive data: [$errorcode] $errormsg \n");
            }

            //print the received message
            echo $buf;
            if (str_contains($buf, 'exit')) {
                echo "Closing socket..." . PHP_EOL;
                socket_close($this->socket);
                $demon = false;
            }
        }
    }

    /**
     * @param array $array
     * @return void
     * @throws \Exception
     */
    public function strategy(array $array): void
    {
        echo match ($array[1] ?? 'default') {
            'server' => $this->server(),
            'client' => $this->client(),
            default => 'default ' . PHP_EOL,
        };
    }
}
