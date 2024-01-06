<?php

namespace App\Infrastructure\Rabbit\Repository;

use App\Application\Action\Notifier\RunnableInterface;
use App\Application\Log\Log;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use phpseclib3\Math\BigInteger\Engines\PHP;

class RabbitClient implements ClientInterface
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
        string $message,
        array $ways = []
    ): void {
        $channel = $this->client->channel();
        $exchange = 'my.exchange';
        $channel->exchange_declare(
            $exchange,
            'direct',
            false,
            true,
            false
        );

        $decode = json_decode($message, true);
        $subscriberTypes = [];
        foreach ($decode['user'] as $key => $item) {
            $lowerKey = strtolower($key);
            if (isset($ways[$lowerKey])) {
                $subscriberTypes[] = $lowerKey;
            }
        }

        foreach ($subscriberTypes as $subscriberType) {
            $channel->basic_publish(
                new AMQPMessage(
                    $message,
                    ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]
                ),
                $exchange,
                $subscriberType
            );
        }
    }

    public function notify(
        string $queue,
        RunnableInterface $notifier,
        string $routingKey
    ): void {
        $this->subscribeByType(
            $queue,
            $routingKey,
            $notifier
        );
    }

    private function subscribeByType(
        string $queue,
        string $routingKey,
        RunnableInterface $notifier
    ): void {
        $channel = $this->client->channel();
        $channel->queue_declare(
            $queue,
            false,
            false,
            false,
            false
        );

        $exchange = 'my.exchange';
        $channel->queue_bind($queue, $exchange, $routingKey);

        $log = $this->log;
        $callback = function ($msg) use ($notifier, $log, $routingKey) {
            $msgCli = sprintf(
                'Read from Rabbit by key `%s` message: %s',
                $routingKey,
                $msg->body
            );
            $log->printConsole($msgCli);
            $log->printConsole(PHP_EOL);
            $log->printConsole(PHP_EOL);
            $notifier->run($msg->body);
            $log->printConsole(PHP_EOL);
        };

        $channel->basic_consume(
            $queue,
            '',
            false,
            true,
            false,
            false,
            $callback
        );

        while (count($channel->callbacks)) {
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
