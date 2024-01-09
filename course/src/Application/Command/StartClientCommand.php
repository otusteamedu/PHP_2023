<?php

namespace Cases\Php2023\Application\Command;

use Exception;

class StartClientCommand extends AbstractCommand
{

    public function execute(...$args)
    {
        $socketPath = "/tmp/socket.sock";

        $running = true;
        while ($running) {
            $client = stream_socket_client("unix:/$socketPath", $errno, $errstr);
            if (!$client) {
                throw new Exception($errstr, $errno);
            }

            $line = readline("Enter message: ");
            fwrite($client, $line);
            $response = fread($client, 1024);
            echo $response;
            if (trim($line) === 'exit') {
                echo "Exiting...\n";
                $running = false;
            }
            fclose($client);
        }
    }
}