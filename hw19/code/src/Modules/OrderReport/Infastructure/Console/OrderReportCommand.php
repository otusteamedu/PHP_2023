<?php

declare(strict_types=1);

namespace Gkarman\Rabbitmq\Modules\OrderReport\Infastructure\Console;

use PhpAmqpLib\Connection\AMQPStreamConnection;

class OrderReportCommand
{
    public function run()
    {
        $configs = parse_ini_file('src/Configs/rabbitMQ.ini');
        $connection = new AMQPStreamConnection($configs['host'], $configs['port'], $configs['user'], $configs['password']);
        $channel = $connection->channel();
        $channel->queue_declare($configs['queue'], false, false, false, false);

        $callback = function ($msg) {
            echo ' [x] Received ', $msg->body, "\n";
        };

        $channel->basic_consume($configs['queue'], '', false, true, false, false, $callback);

        try {
            $channel->consume();
        } catch (\Throwable $exception) {
            echo $exception->getMessage();
        }
    }
}
