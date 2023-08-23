<?php

namespace Jasur\App;

class Server
{

    public function listen($socket)
    {
        $socket->bind();
        $socket->listen();
        echo 'Waiting message';
        $client = $socket->accept();

        var_dump($socket->bind());

        while (true) {
            $incomingData = $socket->receive($client);

            if ($incomingData['message'] === $socket->exitCommand) {
                echo 'Finish chat';
                $socket->close();
                break;
            }

            echo $incomingData['message'];
            $socket->write('Recived' . $incomingData['bytes'], $client);
        }

        $socket->close();
    }

}