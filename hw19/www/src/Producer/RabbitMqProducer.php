<?php
declare(strict_types=1);

namespace Shabanov\Otusphp\Producer;

use PhpAmqpLib\Channel\AbstractChannel;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;
use Shabanov\Otusphp\Connection\ConnectionInterface;

class RabbitMqProducer
{
    private string $connectClient = 'Shabanov\Otusphp\Connection\RabbitMqConnect';
    private AMQPChannel|AbstractChannel $channel;
    private string $exchange = 'shabanov';
    private string $queue = 'otus';
    private ConnectionInterface $connect;

    public function __construct()
    {
        $this->connect = new $this->connectClient();
        $this->channel = $this->connect->getClient();
    }

    public function send(string $message): void
    {
        $this->channel->queue_declare($this->queue, false, true, false, false);
        $this->channel->exchange_declare($this->exchange, AMQPExchangeType::DIRECT, false, true, false);
        $this->channel->queue_bind($this->queue, $this->exchange);

        $this->messagePublish($message);

        $this->channel->close();
        $this->connect->close();
    }

    private function messagePublish(string $message): void
    {
        $message = new AMQPMessage($message, [
            'content_type' => 'text/plain',
            'delivery_mode' => AMQPMessage::DELIVERY_MODE_NON_PERSISTENT
        ]);
        $this->channel->basic_publish($message, $this->exchange);
    }
}
