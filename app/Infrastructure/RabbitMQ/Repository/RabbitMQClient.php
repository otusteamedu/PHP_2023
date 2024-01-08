<?php

namespace App\Infrastructure\RabbitMQ\Repository;

use App\Application\Action\StatusUpdater\RunnableInterface;
use App\Application\Log\Log;
use App\Infrastructure\GetterInterface;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQClient implements ClientInterface
{
    private AMQPStreamConnection $client;
    private Log $log;
    private GetterInterface $cnf;

    public function __construct(
        GetterInterface $config
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
        $this->cnf = $config;
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
        $channel->basic_publish(
            new AMQPMessage($message),
            '',
            $namespace
        );
    }

    public function readAndStatusUpdate(
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
        $callback = function ($message) use ($notifier, $log) {
            $msgCli = sprintf(
                'Read from RabbitMQ message: %s',
                $message->body
            );
            $log->printConsole(PHP_EOL);
            $log->printConsole($msgCli);
            $log->printConsole(PHP_EOL);
            $notifier->run($message->body);
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

        $isProduction = in_array(
            strtolower($this->cnf->get('APP_MODE')),
            ['prod', 'production']
        );
        if ($isProduction) {
            $this->watchProd($channel);
        } else {
            $sec = $this->cnf->get('QA_PAUSE_IN_WATCH_QUEUE') ?? 4;
            $this->watchDev(
                $channel,
                $sec
            );
        }
    }

    private function watchProd(AMQPChannel $channel): void
    {
        while (count($channel->callbacks)) {
            $channel->wait();
        }
    }

    private function watchDev(AMQPChannel $channel, int $sec = 4): void
    {
        while (count($channel->callbacks)) {
            $channel->wait();
            sleep($sec);
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
