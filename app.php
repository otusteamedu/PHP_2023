<?php

declare(strict_types=1);

use Kanakhin\WebSockets\Infrastructure\SocketChat;

require __DIR__ . '/vendor/autoload.php';

try {
    $chat = new SocketChat();
    $chat->run($argv);
} catch (\Exception $e) {

}
