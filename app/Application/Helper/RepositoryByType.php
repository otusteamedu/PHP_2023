<?php

namespace App\Application\Helper;

use App\Infrastructure\Kafka\Repository\KafkaClientQueueRepository;
use App\Infrastructure\Rabbit\Repository\RabbitClientQueueRepository;
use App\Infrastructure\QueueRepositoryInterface;
use App\Infrastructure\RabbitMQ\Repository\RabbitMQClientQueueRepository;
use App\Infrastructure\Redis\Repository\RedisClientQueueRepository;
use NdybnovHw03\CnfRead\Storage;

class RepositoryByType
{
    public function get(Storage $config): QueueRepositoryInterface
    {
        $type = $config->get('USE_REPOSITORY');
        $repositories = [
            'rabbitmq' =>
                RabbitMQClientQueueRepository::class,
            'rabbit' =>
                RabbitClientQueueRepository::class,
            'redis' =>
                RedisClientQueueRepository::class,
            'kafka' =>
                KafkaClientQueueRepository::class,
        ];

        if (!isset($repositories[$type])) {
            $msg = sprintf('Error: type `%s` repository!', $type);
            throw new \RuntimeException($msg);
        }

        return new $repositories[$type]($config);
    }
}
