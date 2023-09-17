<?php

declare(strict_types=1);

namespace DEsaulenko\Hw19\Queue;

use DEsaulenko\Hw19\Interfaces\ClientInterface;
use DEsaulenko\Hw19\Interfaces\PublisherInterface;
use DEsaulenko\Hw19\Rabbit\Publisher;

class QueuePublisher
{
    private PublisherInterface $publisher;

    public function __construct(ClientInterface $client)
    {
        switch (getenv('QUEUE_TYPE')) {
            case QueueConstant::TYPE_CLIENT_RABBIT:
                $this->publisher = new Publisher($client);
                break;
            default:
                throw new \Exception('Не задан тип очереди в .env');
        }
    }

    /**
     * @return PublisherInterface
     */
    public function getPublisher(): PublisherInterface
    {
        return $this->publisher;
    }
}
