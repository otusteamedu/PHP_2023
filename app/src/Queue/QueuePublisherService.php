<?php

declare(strict_types=1);

namespace DEsaulenko\Hw19\Queue;

use DEsaulenko\Hw19\Interfaces\ClientInterface;
use DEsaulenko\Hw19\Interfaces\PublisherInterface;
use DEsaulenko\Hw19\Interfaces\PublisherServiceInterface;
use DEsaulenko\Hw19\Rabbit\Publisher;
use DEsaulenko\Hw19\Rabbit\Service\PublisherService;

class QueuePublisherService
{
    private PublisherServiceInterface $publisherService;

    public function __construct(PublisherInterface $publisher)
    {
        switch (getenv('QUEUE_TYPE')) {
            case QueueConstant::TYPE_CLIENT_RABBIT:
                $this->publisherService = new PublisherService($publisher);
                break;
            default:
                throw new \Exception('Не задан тип очереди в .env');
        }
    }

    /**
     * @return PublisherServiceInterface
     */
    public function getPublisherService(): PublisherServiceInterface
    {
        return $this->publisherService;
    }
}
