<?php

declare(strict_types=1);

namespace DEsaulenko\Hw19\Queue;

use DEsaulenko\Hw19\Interfaces\ClientInterface;
use DEsaulenko\Hw19\Interfaces\ConsumerInterface;
use DEsaulenko\Hw19\Interfaces\ConsumerServiceInterface;
use DEsaulenko\Hw19\Interfaces\PublisherInterface;
use DEsaulenko\Hw19\Interfaces\PublisherServiceInterface;
use DEsaulenko\Hw19\Rabbit\Publisher;
use DEsaulenko\Hw19\Rabbit\Service\ConsumerService;
use DEsaulenko\Hw19\Rabbit\Service\PublisherService;

class QueueConsumerService
{
    private ConsumerServiceInterface $consumerService;

    public function __construct(ConsumerInterface $consumer)
    {
        switch (getenv('QUEUE_TYPE')) {
            case QueueConstant::TYPE_CLIENT_RABBIT:
                $this->consumerService = new ConsumerService($consumer);
                break;
            default:
                throw new \Exception('Не задан тип очереди в .env');
        }
    }

    /**
     * @return ConsumerServiceInterface
     */
    public function getConsumerService(): ConsumerServiceInterface
    {
        return $this->consumerService;
    }
}
