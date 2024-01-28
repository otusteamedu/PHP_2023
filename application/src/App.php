<?php

declare(strict_types=1);

namespace Chat;

use Exception;

class App
{
    public const SERVER = 'server';
    public const CLIENT = 'client';
    public const VALID_PARAMS = [
        self::SERVER,
        self::CLIENT
    ];

    /**
     * @throws Exception
     */
    public function run()
    {
        if (empty($_SERVER['argv'][1])) {
            throw new Exception('Arguments is empty!' . PHP_EOL);
        }

        if (!in_array($_SERVER['argv'][1], self::VALID_PARAMS)) {
            throw new Exception('Arguments is valid!' . PHP_EOL);
        }

        $chat = new Chat();

        if ($_SERVER['argv'][1] == self::SERVER) {
            $server = new Server();
            $server::handle($chat);
        }

        if ($_SERVER['argv'][1] == self::CLIENT) {
            $client = new Client();
            $client::handle($chat);
        }
    }
}
