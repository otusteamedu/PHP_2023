<?php
declare(strict_types=1);

namespace Gkarman\Rabbitmq\Modules\OrderReport\Infastructure\Repository;

use Gkarman\Rabbitmq\Modules\OrderReport\Domain\Entity\OrderReportRequest;
use Gkarman\Rabbitmq\Modules\OrderReport\Domain\Repository\OrderReportRepositoryInterface;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQQueueRepository implements OrderReportRepositoryInterface
{
    private AMQPStreamConnection $connection;

    private AMQPChannel $channel;
    public function __construct()
    {
        $this->init();
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
    private function init(): void
    {
        $configs = parse_ini_file('src/Configs/rabbitMQ.ini');
        $this->connection = new AMQPStreamConnection($configs['host'], $configs['port'], $configs['user'], $configs['password']);
        $this->channel = $this->connection->channel();
        $this->channel->queue_declare($configs['queue'], false, false, false, false);
    }
}
