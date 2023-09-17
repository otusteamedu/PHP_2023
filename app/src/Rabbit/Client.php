<?php

declare(strict_types=1);

namespace DEsaulenko\Hw19\Rabbit;

use DEsaulenko\Hw19\Interfaces\ClientInterface;
use DEsaulenko\Hw19\Queue\QueueConstant;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;

class Client implements ClientInterface
{
    private string $queue;
    private Config $config;
    private string $exchange;
    private AMQPStreamConnection $connection;
    private AMQPChannel $channel;

    /**
     * @param string $queue
     * @param Config $config
     */
    public function __construct(string $queue, Config $config, ?string $exchange = 'some')
    {
        $this->queue = $queue;
        $this->config = $config;
        if (!$exchange) {
            $exchange = QueueConstant::DEFAULT_EXCHANGE_NAME;
        }
        $this->exchange = $exchange;
        $this->connection = new AMQPStreamConnection(
            $this->config->getHost(),
            $this->config->getPort(),
            $this->config->getUser(),
            $this->config->getPass(),
            $this->config->getVhost()
        );
        $this->channel = $this->connection->channel();
        $this->channel->queue_declare($this->queue, false, true, false, false);
        $this->channel->exchange_declare($this->exchange, AMQPExchangeType::TOPIC, false, true, false);
        $this->channel->queue_bind($this->queue, $this->exchange);
    }

    /**
     * @return AMQPStreamConnection
     */
    public function getConnection(): AMQPStreamConnection
    {
        return $this->connection;
    }

    /**
     * @return AMQPChannel
     */
    public function getChannel(): AMQPChannel
    {
        return $this->channel;
    }

    /**
     * @return string
     */
    public function getExchange(): string
    {
        return $this->exchange;
    }

    /**
     * @return string
     */
    public function getQueue(): string
    {
        return $this->queue;
    }

    public function shutdown(): void
    {
        $this->channel->close();
        $this->connection->close();
    }
}
