<?php

declare(strict_types=1);

namespace Vp\App\Application\RabbitMq;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use Vp\App\Application\Contract\DataProcessInterface;
use Vp\App\Application\RabbitMq\Contract\AmqpConnectionInterface;
use Vp\App\Application\RabbitMq\Contract\RabbitReceiverInterface;

class RabbitReceiver implements RabbitReceiverInterface
{
    private AMQPStreamConnection $connection;

    public function __construct(AmqpConnectionInterface $connection)
    {
        $this->connection = $connection->getConnection();
    }

    /**
     * @throws \Exception
     */
    public function listen(string $queueName, DataProcessInterface $dataProcess, string $method): void
    {
        $channel = $this->connection->channel();
        $channel->queue_declare($queueName, false, true, false, false);
        $channel->basic_qos(0, 1, false);
        $channel->basic_consume($queueName, '', false, false, false, false, [$dataProcess, $method]);
        while (count($channel->callbacks)) {
            $channel->wait();
        }
        $channel->close();
        $this->connection->close();
    }
}
