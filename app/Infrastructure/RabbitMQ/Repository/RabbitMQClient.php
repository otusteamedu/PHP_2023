<?php

namespace App\Infrastructure\RabbitMQ\Repository;

use App\Application\Action\Notifier\RunnableInterface;
use App\Application\Log\Log;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQClient implements ClientInterface
{
    private AMQPStreamConnection $client;
    private Log $log;

    public function __construct(
        $config
    ) {
        try {
            $this->client = new AMQPStreamConnection(
                $config->get('RABBITMQ_HOST'),
                $config->get('RABBITMQ_PORT'),
                $config->get('RABBITMQ_USER'),
                $config->get('RABBITMQ_PASSWORD')
            );
        } catch (\Throwable $throwable) {
            throw new \Exception($throwable->getMessage());
        }

        $this->log = new Log();
    }

    public function publish(
        string $namespace,
        string $message
    ): void {
        $channel = $this->client->channel();
        $channel->queue_declare(
            $namespace,
            false,
            false,
            false,
            false
        );
        $exchange = '';
        $channel->basic_publish(
            new AMQPMessage($message),
            $exchange,
            $namespace
        );
    }

    public function notify(
        string $namespace,
        RunnableInterface $notifier
    ): void {
        $channel = $this->client->channel();
        $channel->queue_declare(
            $namespace,
            false,
            false,
            false,
            false
        );

        $log = $this->log;
        $callback = function($message) use ($notifier, $log) {
            $msgCli = sprintf(
                'Read from RabbitMQ message: %s',
                $message->body
            );
            $log->printConsole($msgCli);
            $log->printConsole(PHP_EOL);
            $log->printConsole(PHP_EOL);
            $notifier->run($message->body);
            $log->printConsole(PHP_EOL);
        };

        $channel->basic_consume(
            $namespace,
            '',
            false,
            true,
            false,
            false,
            $callback
        );

        while(count($channel->callbacks)) {
            $channel->wait();
        }
    }

    public function close(): void
    {
        $this->client->channel()->close();
        $this->client->close();
    }

    public function clear(string $queue): void
    {
        $this->client->channel()->queue_purge($queue);
        $this->client->channel()->queue_delete($queue);
    }
}
