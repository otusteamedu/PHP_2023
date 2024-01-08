<?php

namespace App\Application\Helper;

use App\Infrastructure\GetterInterface;
use App\Infrastructure\MessageQueueRepositoryInterface;
use App\Infrastructure\MessageStatusRepositoryInterface;
use App\Infrastructure\RabbitMQ\Repository\RabbitMQClientQueueRepository;
use App\Infrastructure\Redis\Repository\RedisClientStatusRepository;

class StatusRepositoryByType
{
    public function get(GetterInterface $config): MessageStatusRepositoryInterface
    {
        $type = $config->get('USE_STORAGE');
        $repositories = [
            'redis' => RedisClientStatusRepository::class,
        ];

        if (!isset($repositories[$type])) {
            $msg = sprintf('Error: type `%s` repository!', $type);
            throw new \RuntimeException($msg);
        }

        return new $repositories[$type]($config);
    }
}
