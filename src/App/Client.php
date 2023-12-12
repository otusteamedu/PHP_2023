<?php
declare(strict_types=1);

namespace Ekovalev\Otus\App;

class Client extends Socket
{
    public function initChat(): void
    {
        $this->initSocket();
        while (true) {
            echo $this->showMessage('Ваше сообщение: ');
            $message = readline();
            $this->write($message);
            if ($message === '/exit') {
                break;
            }
        }
        $this->close();
    }
    public function initSocket(): void
    {
        $this->create(false);
        $this->connect();
    }
}