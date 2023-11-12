<?php

declare(strict_types=1);

namespace Gesparo\HW\Infrastructure\Storage\Redis;

use Gesparo\HW\Domain\Entity\Event;
use Gesparo\HW\Domain\List\EventList;
use Gesparo\HW\Domain\List\GetConditionList;
use Gesparo\HW\Infrastructure\Storage\BaseStorageFacade;

class ApiStorageFacade extends BaseStorageFacade
{
    private \Redis $redis;

    public function __construct(\Redis $redis)
    {
        $this->redis = $redis;
    }

    /**
     * @throws RedisStorageException
     * @throws \RedisException
     */
    public function clear(): void
    {
        (new Cleaner($this->redis))->clear();
    }

    /**
     * @throws \RedisException
     */
    public function add(EventList $list): void
    {
        $eventSetter = new EventSetter($this->redis);

        foreach ($list as $event) {
            $eventSetter->set($event);
        }
    }

    /**
     * @throws RedisStorageException
     * @throws \RedisException
     */
    public function get(GetConditionList $list): ?Event
    {
        return (new EventGetter($this->redis))->get($list);
    }
}
