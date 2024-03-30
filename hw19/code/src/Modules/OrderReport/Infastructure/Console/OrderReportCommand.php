<?php

declare(strict_types=1);

namespace Gkarman\Rabbitmq\Modules\OrderReport\Infastructure\Console;

use Gkarman\Rabbitmq\Infrastructure\RabbitMQConfigs;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class OrderReportCommand
{
    public function __construct(
        private readonly RabbitMQConfigs $configs
    )
    {}

    public function run()
    {
        $connection = new AMQPStreamConnection(
            $this->configs->getHost(),
            $this->configs->getPort(),
            $this->configs->getUser(),
            $this->configs->getPassword()
        );
        $channel = $connection->channel();
        $channel->queue_declare($this->configs->getQueue(), false, false, false, false);

        $callback = function ($msg) {
            echo ' [x] Received ', $msg->body, "\n";
        };

        $channel->basic_consume($this->configs->getQueue(), '', false, true, false, false, $callback);

        try {
            $channel->consume();
        } catch (\Throwable $exception) {
            echo $exception->getMessage();
        }
    }
}
