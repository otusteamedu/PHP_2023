<?php

declare(strict_types=1);

namespace Yalanskiy\Chat;

use InvalidArgumentException;

/**
 * Class App (main class)
 */
class App
{
    /**
     * Run Server or Client
     * @return void
     */
    public function run(): void
    {
        if (empty($_SERVER['argv'][1])) {
            throw new InvalidArgumentException("Required parameter (server or client) is empty.");
        }

        switch ($_SERVER['argv'][1]) {
            case "server":
                $server = new Server();
                $server->run();
                break;
            case "client":
                $client = new Client();
                $client->run();
                break;
            default:
                throw new InvalidArgumentException("Required parameter (server or client) is incorrect.");
        }
    }
}
