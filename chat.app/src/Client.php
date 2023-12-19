<?php

declare(strict_types= 1);

namespace Dshevchenko\Brownchat;

class Client
{
    private SocketClient $socket;

    public function __construct(array $settings)
    {
        $this->socket = new SocketClient($settings);
    }

    public function run(): void
    {
        fwrite(STDOUT, 'Connecting to server... ');
        
        if ($this->socket->connect()) {
            echo "OK\n\n";
        } else {
            throw new \Exception('Cannot connect to socket');
        }

        $isRunning = true;

        while ($isRunning) {
            echo '>>> ';
            $message = fgets(STDIN);
            $message = trim($message); // Обрезаем перевод строки
            if ($message !== '') {
                $this->socket->write($message);
                $confirmation = $this->socket->read();
                if (str_starts_with($confirmation, 'Received')) {
                    fwrite(STDOUT, "\e[90mSRV $confirmation\e[0m\n");
                }
                if (in_array($message, ['/exit', '/stopserver'])) {
                    $isRunning = false;
                }
            }
        }
        fwrite(STDOUT, 'Disconnecting... ');
        $this->socket->close();
        fwrite(STDOUT, "OK\n");
    }
}
