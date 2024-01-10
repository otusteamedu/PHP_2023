<?php

declare(strict_types=1);

namespace Storage;

use Storage\Interface\StorageInterface;
use Redis;

class RedisStorage extends Storage implements StorageInterface
{
     public function buildClient(): void
     {
        $redis = new Redis();
        $redis->connect('redis', 6379);
        $this->client = $redis;
     }

     public function add($key, $score, $events): int | null
     {
        return $this->client->zadd($key, $score, $events);
     }

     public function delete($key): bool | int
     {
          return $this->client->del($key);
     }

     public function get($key): array | null
     {   
         return $this->client->zRevRange($key, 0, -1, ['withscores' => true]);
     }

     public function getAll(): array
     {
          $data = [];
          $keys = $this->client->keys('*');
          foreach ($keys as $key) {
               $data[$key] = $this->client->zRevRange($key, 0, -1, ['withscores' => true]);
          }
          return $data;
     }

     public function getKey($conditions): string
     {
        $key = 'events:';
        foreach ($conditions as $k => $v) {
          $key .= $k . ':' . $v . '|';
        }
        return substr($key, 0, -1);
     }

     public function hasKey($key, $event): bool | int
     {
          return $this->client->zRank($key, $event);
     }
}
