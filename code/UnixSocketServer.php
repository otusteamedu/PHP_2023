<?php

namespace Daniel\Socketchat;

class UnixSocketServer
{
    private $socketPath;
    private $socket;

    public function __construct($configPath)
    {
        $config = parse_ini_file($configPath);
        $this->socketPath = $config['socket_path'] ?? "/tmp/unix.sock";
    }

    public function start()
    {
        if (file_exists($this->socketPath)) {
            unlink($this->socketPath);
        }

        $this->socket = stream_socket_server("unix://{$this->socketPath}", $errno, $errstr);
        if (!$this->socket) {
            throw new \Exception("Error creating socket: $errstr ($errno)");
        }

        echo "Server started\n";
        $this->listen();
    }

    private function listen()
    {
        while ($conn = stream_socket_accept($this->socket, -1)) {
            while ($message = trim(fread($conn, 1024))) {
                echo "Received message: $message\n";

                $response = "Received " . strlen($message) . " bytes";
                fwrite($conn, $response);

                if ($message === 'quit') {
                    fwrite($conn, "Closing connection.\n");
                    fclose($conn);
                    break;
                }
            }
        }

        $this->stop();
    }

    private function stop()
    {
        fclose($this->socket);
    }
}

try {
    $server = new UnixSocketServer( 'config.ini');
    $server->start();
} catch (\Exception $e) {
    echo "An error occurred: " . $e->getMessage() . "\n";
    exit(1);
}
