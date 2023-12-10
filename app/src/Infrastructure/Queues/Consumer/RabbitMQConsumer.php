<?php

namespace App\Infrastructure\Queues\Consumer;

use App\Domain\Repository\ApplicationFormInterface;
use App\Infrastructure\Notification\EmailNotificationInterface;
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
    private ApplicationFormInterface $repository;
    private EmailNotificationInterface $notificator;

    /**
     * @throws Exception
     */
    public function __construct(ApplicationFormInterface $repository, EmailNotificationInterface $notificator)
    {
        $this->notificator = $notificator;
        $this->repository = $repository;
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

            $data = json_decode($message->content, true);
            $email = $this->repository->findOneById($data['id'])->getEmail()->getValue();
            $this->notificator->send("The application has been accepted for processing", 'TEST', $email);

            $channel->ack($message);
        }, $this->queue);
    }

    public function run(): void
    {
        $this->client->run();
    }
}
