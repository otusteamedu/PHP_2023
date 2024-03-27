<?php
declare(strict_types=1);

namespace Shabanov\Otusphp\Messaging\Producer;

use PhpAmqpLib\Message\AMQPMessage;
use Shabanov\Otusphp\Connect\ChannelInterface;
use Shabanov\Otusphp\Connect\ConnectInterface;

class RabbitMqProducer
{
    private ChannelInterface $channel;
    public function __construct(private readonly ConnectInterface $connect)
    {
        $this->channel = $connect->getClient();
        $this->channel->setExchange($_ENV['BROKER_EXCHANGE'])
            ->setQueue($_ENV['BROKER_QUEUE'])
            ->bindQueue($_ENV['BROKER_QUEUE'], $_ENV['BROKER_EXCHANGE']);
    }

    /**
     * @throws \Exception
     */
    public function send(string $message): void
    {
        $amqpMessage = new AMQPMessage($message, [
            'content_type' => 'text/json',
            'delivery_mode' => AMQPMessage::DELIVERY_MODE_NON_PERSISTENT,
        ]);
        $this->channel->send($amqpMessage);
        $this->close();
    }

    /**
     * @throws \Exception
     */
    private function close(): void
    {
        $this->channel->close();
        $this->connect->close();
    }
}
