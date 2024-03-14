<?php

declare(strict_types=1);

namespace App\Rabbit;

use App\Queue\QueueConstant;
use App\Rabbit\Interfaces\ClientInterface;
use App\Rabbit\Interfaces\ConfigInterface;
use Exception;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;

class Client implements ClientInterface
{
    private AMQPStreamConnection $connection;
    private AMQPChannel $channel;

    /**
     * @throws Exception
     */
    public function __construct(ConfigInterface $config)
    {
        $this->connection = new AMQPStreamConnection($config->getHost(), $config->getPort(), $config->getUser(), $config->getPassword());

        $this->channel = $this->connection->channel();
        $this->channel->queue_declare(QueueConstant::QUEUE_NAME, false, true, false, false);
        $this->channel->exchange_declare(QueueConstant::EXCHANGE_NAME, AMQPExchangeType::TOPIC, false, true, false);
        $this->channel->queue_bind(QueueConstant::QUEUE_NAME, QueueConstant::EXCHANGE_NAME);
    }

    public function getConnection(): AMQPStreamConnection
    {
        return $this->connection;
    }

    public function getChannel(): AMQPChannel
    {
        return $this->channel;
    }

    /**
     * @throws Exception
     */
    public function close(): void
    {
        $this->channel->close();
        $this->connection->close();
    }
}
