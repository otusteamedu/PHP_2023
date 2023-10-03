<?php

namespace App\Storage;

use Redis;

class RedisStorage implements Storage
{
    private $redis;

    public function __construct()
    {
        $this->redis = new Redis();
        $this->redis->connect('redis');
    }

    public function add($priority, $conditions, $event)
    {
        $this->redis->zAdd('events', $priority, json_encode(['conditions' => $conditions, 'event' => $event]));
    }

    public function clear()
    {
        $this->redis->del('events');
    }

    public function get($params)
    {
        $events = $this->redis->zRevRange('events', 0, -1);

        foreach ($events as $event) {
            $eventData = json_decode($event, true);
            $conditionsMet = true;
            foreach ($eventData['conditions'] as $key => $value) {
                if (!isset($params[$key]) || $params[$key] != $value) {
                    $conditionsMet = false;
                    break;
                }
            }
            if ($conditionsMet) {
                return $eventData['event'];
            }
        }

        return null;
    }
}