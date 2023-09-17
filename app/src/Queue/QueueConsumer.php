<?php

declare(strict_types=1);

namespace DEsaulenko\Hw19\Queue;

use DEsaulenko\Hw19\Interfaces\ClientInterface;
use DEsaulenko\Hw19\Interfaces\ConsumerInterface;
use DEsaulenko\Hw19\Interfaces\PublisherInterface;
use DEsaulenko\Hw19\Rabbit\Consumer;
use DEsaulenko\Hw19\Rabbit\Publisher;

class QueueConsumer
{
    private ConsumerInterface $consumer;

    public function __construct(ClientInterface $client)
    {
        switch (getenv('QUEUE_TYPE')) {
            case QueueConstant::TYPE_CLIENT_RABBIT:
                $this->consumer = new Consumer($client);
                break;
            default:
                throw new \Exception('Не задан тип очереди в .env');
        }
    }

    /**
     * @return ConsumerInterface
     */
    public function getConsumer(): ConsumerInterface
    {
        return $this->consumer;
    }
}
