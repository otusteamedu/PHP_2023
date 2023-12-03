<?php

namespace Cases\Php2023\Application\Command;

class StartServerCommand extends AbstractCommand
{
    public function execute()
    {
        $socketPath = "/tmp/socket.sock";

        if (file_exists($socketPath)) {
            unlink($socketPath);
        }

        $socket = stream_socket_server("unix://$socketPath", $errno, $errstr);
        if (!$socket) {
            die("$errstr ($errno)\n");
        }

        stream_set_blocking($socket, 0);

        while (true) {
            $read = [$socket];
            $write = null;
            $except = null;
            if (stream_select($read, $write, $except, $tv_sec = 5)) {
                if (in_array($socket, $read)) {
                    if (($conn = stream_socket_accept($socket, -1)) !== false) {
                        $message = fread($conn, 1024);
                        echo "Message received: $message\n";
                        fwrite($conn, "Received " . strlen($message) . " bytes\n");
                        fclose($conn);
                    }
                }
            } else {
                echo "No active connections.\n";
            }
        }

        fclose($socket);
    }
}