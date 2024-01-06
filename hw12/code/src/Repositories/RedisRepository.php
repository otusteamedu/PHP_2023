<?php

namespace Gkarman\Redis\Repositories;

use Gkarman\Redis\Dto\EventDto;
use Redis;

class RedisRepository implements RepositoryInterface
{
    const KEY_EVENTS = 'events';

    private Redis $redis;

    public function __construct()
    {
        $configs = parse_ini_file('src/Configs/app.ini');
        $this->redis = new Redis([
            'host' => $configs['redis_host'],
            'port' => intval($configs['redis_port']),
        ]);
    }

    /**
     * @throws \RedisException
     */
    public function saveEvent(EventDto $eventDto): bool
    {
        $result = boolval($this->redis->zAdd(self::KEY_EVENTS, $eventDto->priority, $eventDto->code));
        return $result;
    }

    /**
     * @throws \RedisException
     */
    public function clearEvents(): bool
    {
        $result = boolval($this->redis->del(self::KEY_EVENTS));
        return $result;
    }
}
