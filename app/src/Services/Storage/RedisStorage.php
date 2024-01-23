<?php

declare(strict_types=1);

namespace Yevgen87\App\Services\Storage;

use Exception;
use Redis;

class RedisStorage implements StorageInterface
{
    /**
     * @var Redis
     */
    private Redis $client;

    public function __construct()
    {
        $this->client = new Redis();
        $this->client->connect('redis', 6379);
    }

    /**
     * @param integer $priority
     * @param array $condition
     * @param string $event
     * @return void
     */
    public function store(int $priority, array $conditions, string $event)
    {
        $data = [
            'conditions' => $conditions,
            'event' => $event
        ];

        $this->client->zadd('events', $priority, json_encode($data));
    }

    /**
     * @return void
     */
    public function deleteAll()
    {
        $keys = $this->client->keys('*');

        foreach ($keys as $key) {
            $this->delete($key);
        }
    }

    /**
     * @param string $key
     * @return void
     */
    public function delete(string $key)
    {
        $this->client->del($key);
    }

    public function getRelevant(array $params)
    {
        $events = $this->client->zrevrange('events', 0, -1);

        foreach ($events as $event) {
            $event = json_decode($event, true);

            $conditions = $event['conditions'];

            try {
                foreach ($conditions as $key => $value) {
                    if (!isset($params[$key]) or $params[$key] != $value) {
                        throw new Exception();
                    }
                }
            } catch (\Exception $e) {
                continue;
            }

            return $event['event'];
        }

        return null;
    }
}
