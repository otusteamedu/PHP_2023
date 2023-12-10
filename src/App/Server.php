<?php
declare(strict_types=1);

namespace Ekovalev\Otus\App;

class Server extends Socket
{
    public function initChat(): void
    {
        $this->initSocket();
        echo $this->showMessage('Ожидание клиента...');
        $client = $this->accept();
        while (true) {
            $message = $this->receive($client);
            if ($message === '/exit') {
                socket_close($client);
                break;
            }
            if ($message) {
                echo $message . PHP_EOL;
                $this->write($message, $client);
            }
        }
        $this->close();
    }
    public function initSocket(): void
    {
        $this->create();
        $this->bind();
        $this->listen();
    }
}