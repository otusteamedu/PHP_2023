<?php

namespace Jasur\App;

class Client
{
    public function sendMessage($socket)
    {
        $socket->connect();


        while (true) {
            $message = readline('Enter message');
            if ($message = '') {
                echo 'Empty message \n';
                continue;
            }
            $socket->write($message);

            if ($message === $socket->exitCommand) {
                echo 'Finish chat';
                $socket->close();
                break;
            }

            echo $socket->read();
        }
    }
}