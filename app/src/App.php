<?php

declare(strict_types=1);

namespace Chat;

use Exception;
use Chat\Chat;

final class App
{
    /**
     * @throws Exception
     */
    public function run(): void
    {
        if (empty($_SERVER['argv'][1])) {
            throw new Exception('Arguments is empty!' . PHP_EOL);
        }

        if (!in_array($_SERVER['argv'][1], ['server', 'client'])) {
            throw new Exception('Arguments is valid!' . PHP_EOL);
        }

        $chat = new Chat();

        if ($_SERVER['argv'][1] == 'server') {
            $server = new Server();
            $server::processing($chat);
        }

        if ($_SERVER['argv'][1] == 'client') {
            $client = new Client();
            $client::processing($chat);
        }
    }
}
