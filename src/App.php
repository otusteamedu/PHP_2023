<?php

declare(strict_types=1);

namespace App;

use App\Queue\QueueClient;
use App\Queue\QueueConstant;
use App\QueueClient\QueueClientInterface;
use Exception;

class App
{
    /**
     * @throws Exception
     */
    public function run(): void
    {
        $client = (new QueueClient(QueueConstant::QUEUE_TYPE_RABBIT))->getClient();

        if ($this->isCLI()) {
            $this->consume($client);
        } else {
            $this->publish($client);
        }
    }

    private function isCLI(): bool
    {
        return PHP_SAPI === 'cli';
    }

    private function publish(QueueClientInterface $client): void
    {
        $msg = $_POST['msg'] ?? 'пустой запрос';
        $client->publish($msg);
    }

    private function consume(QueueClientInterface $client): void
    {
        $client->consume();
    }
}
