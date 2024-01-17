<?php

namespace Santonov\Otus\Chat;

use Exception;
use Socket;

final class ChatServer extends Chat
{
    /**
     * @throws Exception
     */
    public function __construct()
    {
        parent::__construct();
        if (file_exists($this->socketPath)) unlink($this->socketPath);
        $this->create();
        $this->bind();
        $this->listen();
    }

    public function process(): void
    {
        echo 'Waiting for connections ' . PHP_EOL;
        $connection = $this->accept();
        while (true) {
            $message = $this->read($connection);
            if ($message === '/exit') {
                break;
            }
            if ($message) {
                echo 'Message: ' . $message . PHP_EOL;
            }
            $this->write(
                'Server received message ' . strlen($message) . ' symbols',
                $connection,
            );
        }
        $this->close();
    }
}
