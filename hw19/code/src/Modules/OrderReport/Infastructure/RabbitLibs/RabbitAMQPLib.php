<?php

declare(strict_types=1);

namespace Gkarman\Rabbitmq\Modules\OrderReport\Infastructure\RabbitLibs;

use Gkarman\Rabbitmq\Infrastructure\RabbitMQConfigs;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitAMQPLib
{
    private RabbitMQConfigs $configs;
    private AMQPStreamConnection $connection;
    private AMQPChannel $channel;
    public function __construct(RabbitMQConfigs $configs)
    {
        $this->configs = $configs;
        $this->connection = $this->initConnection();
        $this->channel = $this->initChannel();
    }

    private function initConnection(): AMQPStreamConnection
    {
        $connection = new AMQPStreamConnection(
            $this->configs->getHost(),
            $this->configs->getPort(),
            $this->configs->getUser(),
            $this->configs->getPassword()
        );

        return $connection;
    }

    private function initChannel(): AMQPChannel
    {
        $channel = $this->connection->channel();
        $channel->queue_declare($this->configs->getQueue(), false, false, false, false);
        return $channel;
    }
    public function publish(string $message): void
    {
        $msg = new AMQPMessage($message);
        $this->channel->basic_publish($msg, '', 'otus');
        $this->channel->close();
        $this->connection->close();
    }
}
