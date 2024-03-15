<?php

declare(strict_types=1);

namespace App\QueueClient\Rabbit;

use App\Queue\QueueConstant;
use App\QueueClient\QueueClientInterface;
use ErrorException;
use Exception;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitClient implements QueueClientInterface
{
    private AMQPStreamConnection $connection;
    private AMQPChannel $channel;

    /**
     * @throws Exception
     */
    public function __construct(RabbitConfigInterface $config)
    {
        $this->connection = new AMQPStreamConnection($config->getHost(), $config->getPort(), $config->getUser(), $config->getPassword());

        $this->channel = $this->connection->channel();
        $this->channel->queue_declare(QueueConstant::QUEUE_NAME, false, true, false, false);
        $this->channel->exchange_declare(QueueConstant::EXCHANGE_NAME, AMQPExchangeType::TOPIC, false, true, false);
        $this->channel->queue_bind(QueueConstant::QUEUE_NAME, QueueConstant::EXCHANGE_NAME);
    }

    /**
     * @throws ErrorException
     */
    public function consume(): void
    {
        echo " [*] Waiting for messages. To exit press CTRL+C\n";

        $callback = function ($msg) {
            echo $msg->body . PHP_EOL;

            if ($msg->body === 'quit') {
                $this->close();
            }
        };

        $this->channel->basic_consume(QueueConstant::QUEUE_NAME, '', false, true, false, false, $callback);
        $this->channel->consume();
    }

    /**
     * @throws Exception
     */
    public function publish(string $message): void
    {
        $msg = new AMQPMessage($message);
        $this->channel->basic_publish($msg, QueueConstant::EXCHANGE_NAME);
        $this->close();
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
