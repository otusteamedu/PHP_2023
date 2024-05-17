<?php

declare(strict_types=1);

namespace app\components;

use Exception;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use yii\base\Component;

class RabbitMq extends Component
{
    private AMQPStreamConnection $connection;
    private AMQPChannel $channel;

    public function init(): void
    {
        parent::init();
        $this->connection = new AMQPStreamConnection(
            $_ENV['RABBITMQ_HOST'],
            5672,
            $_ENV['RABBITMQ_USER'],
            $_ENV['RABBITMQ_PASS']
        );
        $this->channel = $this->connection->channel();
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
