<?php

declare(strict_types=1);

namespace Eevstifeev\Chat;
use Eevstifeev\Chat\Handlers\ClientSocket;
use Eevstifeev\Chat\Handlers\ServerSocket;

final class Chat
{
    public function exec($argv): void
    {
        $config = new Config();
        if (!isset($argv[1]) || !in_array($argv[1], ['client', 'server'])) {
            throw new \InvalidArgumentException('No client or server argument!');
        }
        try {
            $type = strtolower($argv[1]);
            if ($type === 'client') {
                $client = new ClientSocket($config);
                $client->handle();
            } elseif ($type ==='server') {
                $server = new ServerSocket($config);
                $server->handle();
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
