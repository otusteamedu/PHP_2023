<?php

namespace App\Application\Helper;

use App\Infrastructure\GetterInterface;
use App\Infrastructure\MessageQueueRepositoryInterface;
use App\Infrastructure\RabbitMQ\Repository\RabbitMQClientQueueRepository;
use App\Infrastructure\Redis\Repository\RedisClientStatusRepository;

class QueueRepositoryByType
{
    public function get(GetterInterface $config): MessageQueueRepositoryInterface
    {
        $type = $config->get('USE_REPOSITORY');
        $repositories = [
            'rabbitmq' => RabbitMQClientQueueRepository::class,
        ];

        if (!isset($repositories[$type])) {
            $msg = sprintf('Error: type `%s` repository!', $type);
            throw new \RuntimeException($msg);
        }

        return new $repositories[$type]($config);
    }
}
