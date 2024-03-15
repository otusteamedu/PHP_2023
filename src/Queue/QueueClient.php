<?php

declare(strict_types=1);

namespace App\Queue;

use App\QueueClient\QueueClientInterface;
use App\QueueClient\Rabbit\RabbitClient;
use App\QueueClient\Rabbit\RabbitConfig;
use App\QueueClient\Redis\RedisClient;
use App\QueueClient\Redis\RedisConfig;
use Exception;

class QueueClient
{
    private QueueClientInterface $client;

    /**
     * @throws Exception
     */
    public function __construct(string $queueType)
    {
        switch ($queueType) {
            case QueueConstant::QUEUE_TYPE_RABBIT:
                $config = new RabbitConfig();
                $client = new RabbitClient($config);
                break;
            case QueueConstant::QUEUE_TYPE_REDIS:
                $config = new RedisConfig();
                $client = new RedisClient($config);
                break;
            default:
                throw new Exception('Invalid queue type');
        }

        $this->client = $client;
    }

    public function getClient(): QueueClientInterface
    {
        return $this->client;
    }
}
