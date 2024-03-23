<?php

declare(strict_types=1);

namespace Gkarman\Rabbitmq\Modules\OrderReport\Infastructure\Repository;

use Gkarman\Rabbitmq\Infrastructure\RabbitMQConfigs;
use Gkarman\Rabbitmq\Modules\OrderReport\Domain\Entity\OrderReportRequest;
use Gkarman\Rabbitmq\Modules\OrderReport\Domain\Repository\OrderReportRepositoryInterface;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQQueueRepository implements OrderReportRepositoryInterface
{
    private AMQPStreamConnection $connection;

    private AMQPChannel $channel;

    public function __construct(
        RabbitMqConfigs $rabbitMQConfigs,
    ) {
        $this->init($rabbitMQConfigs);
    }

    public function save(OrderReportRequest $request): void
    {
        $msg = new AMQPMessage(serialize($request));
        $this->channel->basic_publish($msg, '', 'otus');
        $this->channel->close();
        $this->connection->close();
    }

    /**
     * @throws \Exception
     */
    private function init(RabbitMqConfigs $rabbitMQConfigs): void
    {
        $this->connection = new AMQPStreamConnection(
            $rabbitMQConfigs->getHost(),
            $rabbitMQConfigs->getPort(),
            $rabbitMQConfigs->getUser(),
            $rabbitMQConfigs->getPassword()
        );
        $this->channel = $this->connection->channel();
        $this->channel->queue_declare($rabbitMQConfigs->getQueue(), false, false, false, false);
    }
}
