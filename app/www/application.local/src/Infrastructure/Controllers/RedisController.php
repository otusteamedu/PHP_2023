<?php

declare(strict_types=1);

namespace AYamaliev\hw12\Infrastructure\Controllers;

use AYamaliev\hw12\Application\Dto\EventDto;
use AYamaliev\hw12\Application\Dto\SearchDto;
use AYamaliev\hw12\Domain\Entity\Event;
use AYamaliev\hw12\Infrastructure\Repository\RedisRepository;

class RedisController
{
    public function add(EventDto $eventDto): void
    {
        $redis = new RedisRepository();
        $redis->add(new Event($eventDto->getPriority(), $eventDto->getEvent(), $eventDto->getParam1(), $eventDto->getParam2()));
    }

    public function get(SearchDto $searchDto): ?Event
    {
        $redis = new RedisRepository();
        return $redis->get($searchDto);
    }

    public function clear(): void
    {
        $redis = new RedisRepository();
        $redis->clear();
    }

    public function getAll(): array
    {
        $redis = new RedisRepository();
        return $redis->getAll();
    }
}
