<?php

declare(strict_types=1);

namespace DEsaulenko\Hw19\Rabbit;

use DEsaulenko\Hw19\Interfaces\ClientInterface;
use DEsaulenko\Hw19\Interfaces\ConsumerInterface;
use DEsaulenko\Hw19\Job\Report;
use DEsaulenko\Hw19\Queue\QueueConstant;
use DEsaulenko\Hw19\Subscriber\SubscriberTelegramNotification;
use PhpAmqpLib\Message\AMQPMessage;

class Consumer implements ConsumerInterface
{
    private ClientInterface $client;

    /**
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function execute(): void
    {
        $this->client->getChannel()->basic_consume(
            $this->client->getQueue(),
            QueueConstant::QUEUE_CONSUMER_TAG,
            false,
            false,
            false,
            false,
            [$this, 'processMessage']
        );
        $this->client->getChannel()->consume();
    }

    public function processMessage(AMQPMessage $message): void
    {
        echo "\n--------\n";
        echo $message->body;
        echo "\n--------\n";

        $this->doSomething($message->body);

        $message->ack();

        if ($message->body === 'quit') {
            $message->getChannel()->basic_cancel($message->getConsumerTag());
        }
    }

    public function doSomething(string $messageBody): void
    {
        $data = json_decode($messageBody, true);
        $subscriberTelegram = new SubscriberTelegramNotification((int)$data['chat_id']);
        (new Report())
            ->attach($subscriberTelegram)
            ->execute($data);
    }
}