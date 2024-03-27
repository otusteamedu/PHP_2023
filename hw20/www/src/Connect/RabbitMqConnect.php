<?php
declare(strict_types=1);

namespace Shabanov\Otusphp\Connect;

use PhpAmqpLib\Connection\AMQPStreamConnection;


class RabbitMqConnect implements ConnectInterface
{
    private AMQPStreamConnection $connect;
    public function __construct()
    {
        $this->connect = new AMQPStreamConnection(
            $_ENV['BROKER_HOST'],
            $_ENV['BROKER_PORT'],
            $_ENV['BROKER_LOGIN'],
            $_ENV['BROKER_PASSWORD'],
        );
    }
    public function getClient(): ChannelInterface
    {
        $channel = $this->connect->channel();
        return new RabbitMqChannel($channel);
    }

    /**
     * @throws \Exception
     */
    public function close(): void
    {
        $this->connect->close();
    }
}
