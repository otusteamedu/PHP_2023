<?php

declare(strict_types=1);

namespace Twent\Chat\Servers;

use Generator;
use Twent\Chat\Servers\Contracts\ServerContract;
use Twent\Chat\Sockets\BaseSocketClient;
use Twent\Chat\Sockets\BaseSocketManager;
use Twent\Chat\Sockets\UnixSocketClient;

final class Client extends BaseServer
{
    public function __construct(BaseSocketClient|BaseSocketManager $socketManager)
    {
        parent::__construct($socketManager);
        $this->socketManager->connect();
    }

    public static function getInstance(): ?ServerContract
    {
        if (! self::$instance) {
            self::$instance = new self(UnixSocketClient::getInstance());
        }

        return self::$instance;
    }

    public function run(): Generator
    {
        while (true) {
            yield 'Введите сообщение: ';
            $message = fgets(fopen('php://stdin', 'r'));
            $this->socketManager->write($message);
            yield $this->socketManager->read();
        }
    }
}
