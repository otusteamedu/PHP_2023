<?php

declare(strict_types=1);

namespace Vp\App\Application\Consumer;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use Vp\App\Application\Builder\Contract\RabbitReceiverBuilderInterface;
use Vp\App\Application\Consumer\Contract\RabbitReceiverInterface;
use Vp\App\Application\Contract\DataProcessInterface;

class RabbitReceiver implements RabbitReceiverInterface
{
    private string $host;
    private string $port;
    private string $user;
    private string $password;

    public function __construct(RabbitReceiverBuilderInterface $builder)
    {
        $this->host = $builder->getHost();
        $this->port = $builder->getPort();
        $this->user = $builder->getUser();
        $this->password = $builder->getPassword();
    }

    public function listen(string $queueName, DataProcessInterface $dataProcess, string $method): void
    {
        try {
            $connection = new AMQPStreamConnection($this->host, $this->port, $this->user, $this->password);
            $channel = $connection->channel();
            $channel->queue_declare($queueName, false, true, false, false);
            $channel->basic_qos(0, 1, false);
            $channel->basic_consume($queueName, '', false, false, false, false, [$dataProcess, $method]);
            while(count($channel->callbacks)) {
                $channel->wait();
            }
            $channel->close();
            $connection->close();

        } catch (\Exception $e) {
        }
    }
}
