<?php

namespace Santonov\Otus\Chat;

use Exception;

final class ChatClient extends Chat
{
    /**
     * @throws Exception
     */
    public function __construct()
    {
        parent::__construct();
        $this->create();
        $this->connect();
    }

    public function process(): void
    {
        while (true) {
            echo 'Input message: ';
            $message = readline();
            $this->write($message);
            if ($message === '/exit') {
                break;
            }
            echo $this->read() . PHP_EOL;
        }
        $this->close();
    }
}