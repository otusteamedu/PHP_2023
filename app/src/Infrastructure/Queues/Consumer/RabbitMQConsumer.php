<?php

namespace App\Infrastructure\Queues\Consumer;

use Bunny\Channel;
use Bunny\Client;
use Bunny\Message;
use Exception;
use React\Promise\PromiseInterface;

class RabbitMQConsumer implements ConsumerInterface
{
    private Client $client;
    private string $queue;
    private PromiseInterface|Channel $channel;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->client = new Client([
            'host'      => 'rabbitmq',
            'vhost'     => '/',
            'user'      => $_ENV['RABBITMQ_DEFAULT_USER'],
            'password'  => $_ENV['RABBITMQ_DEFAULT_PASS'],
        ]);
        $this->queue = $_ENV['QUEUE'];

        $this->client->connect();
        $this->channel = $this->client->channel();

        $this->channel->qos(prefetchCount: 1);

        $this->consume();
    }

    private function consume(): void
    {
        $this->channel->consume(function (Message $message, Channel $channel): void {
            var_dump($message->content);
            $channel->ack($message);
        }, $this->queue);
    }

    public function run(): void
    {
        $this->client->run();
    }
}
