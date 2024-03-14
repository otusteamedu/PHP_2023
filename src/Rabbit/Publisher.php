<?php

declare(strict_types=1);

namespace App\Rabbit;

use App\Queue\QueueConstant;
use App\Rabbit\Interfaces\ClientInterface;
use App\Rabbit\Interfaces\PublisherInterface;
use PhpAmqpLib\Message\AMQPMessage;

readonly class Publisher implements PublisherInterface
{
    public function __construct(private ClientInterface $client)
    {
    }

    public function publish(string $message): void
    {
        $msg = new AMQPMessage($message);
        $this->client->getChannel()->basic_publish($msg, QueueConstant::EXCHANGE_NAME);
        $this->client->close();
    }
}
