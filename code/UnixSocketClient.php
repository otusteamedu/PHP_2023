<?php

namespace Daniel\Socketchat;

class UnixSocketClient
{
    private $socketPath;
    private $socket;

    public function __construct($configPath)
    {
        $config = parse_ini_file($configPath);
        $this->socketPath = $config['socket_path'] ?? "/tmp/unix.sock";
    }

    public function connect()
    {
        $this->socket = @stream_socket_client("unix://{$this->socketPath}", $errno, $errstr);

        if (!$this->socket) {
            throw new \Exception("Error connecting to socket: $errstr ($errno)");
        }
    }

    public function sendMessage($message)
    {
        fwrite($this->socket, $message);
        $response = fread($this->socket, 1024);
        return $response;
    }

    public function close()
    {
        fclose($this->socket);
    }
}

try {
    $client = new UnixSocketClient( 'config.ini');
    $client->connect();

    $stdin = fopen('php://stdin', 'r');

    while (true) {
        echo "Enter a message to send to the server (type 'quit' to exit):\n";
        $input = trim(fgets($stdin));

        if ($input === 'quit') {
            $client->close();
            break;
        }

        $response = $client->sendMessage($input);
        echo $response . "\n";
    }
} catch (\Exception $e) {
    echo "An error occurred: " . $e->getMessage() . "\n";
    exit(1);
}
