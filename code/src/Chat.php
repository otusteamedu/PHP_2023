<?php

declare(strict_types=1);

namespace EEvstifeev\Chat;
final class Chat
{
    public function exec($argv): void
    {
        if (!isset($argv[1]) || !in_array($argv[1], ['client', 'server'])) {
            throw new \InvalidArgumentException('No client or server argument!');
        }
        try {
            $type = strtolower($argv[1]);
            if ($type === 'client') {
                $client = new ClientHandler();
                $client->handle(new Socket());
            } elseif ($type ==='server') {
                $server = new ServerHandler();
                $server->handle(new Socket());
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
