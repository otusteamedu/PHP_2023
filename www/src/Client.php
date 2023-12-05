<?php

declare(strict_types=1);

namespace Yalanskiy\Chat;

use RuntimeException;

/**
 * Class Client
 */
class Client
{
    private Socket $socket;
    public function __construct()
    {
        $this->socket = new Socket();
    }

    /**
     * Run client
     * @return void
     */
    public function run(): void
    {
        try {
            while (true) {
                fwrite(STDOUT, "Input message: ");
                $input = trim(fgets(STDIN));
                $this->socket->connect();
                $this->socket->send($input);
                $response = $this->socket->receive();
                fwrite(STDOUT, "Server response: $response" . PHP_EOL);
                if ($input === "quit") {
                    break;
                }
            }
        } catch (RuntimeException $exception) {
            throw new RuntimeException($exception->getMessage());
        }
    }
}
