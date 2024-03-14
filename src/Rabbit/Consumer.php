<?php

declare(strict_types=1);

namespace App\Rabbit;

use App\Queue\QueueConstant;
use App\Rabbit\Interfaces\ClientInterface;
use App\Rabbit\Interfaces\ConsumerInterFace;
use ErrorException;
use PhpAmqpLib\Message\AMQPMessage;

readonly class Consumer implements ConsumerInterFace
{
    public function __construct(private ClientInterface $client)
    {
    }

    /**
     * @throws ErrorException
     */
    public function consume(): void
    {
        echo " [*] Waiting for messages. To exit press CTRL+C\n";

        $channel = $this->client->getChannel();
        $channel->basic_consume(QueueConstant::QUEUE_NAME, '', false, true, false, false, [$this, 'readMessage']);
        $channel->consume();
    }

    public function readMessage(AMQPMessage $msg): void
    {
        echo $msg->body . PHP_EOL;

        if ($msg->body === 'quit') {
            $this->client->close();
        }
    }
}
