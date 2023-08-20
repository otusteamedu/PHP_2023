<?php

declare(strict_types=1);

namespace App\Service;

use Redis;
use RedisException;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class RedisClient
{
    private const MIN_TTL = 1;
    private const MAX_TTL = 3600;

    private Redis|null $redis = null;

    public function __construct(
        #[Autowire(env: 'REDIS_HOST')]
        private readonly string $host,
        #[Autowire(env: 'REDIS_PORT')]
        private readonly int $port,
    ) {
    }

    /**
     * Get the value related to the specified key.
     * @throws RedisException
     */
    public function get(string $key): false|string
    {
        $this->connect();

        return $this->redis->get($key);
    }

    /**
     * set(): Set persistent key-value pair.
     * setex(): Set non-persistent key-value pair.
     * @throws RedisException
     */
    public function set(string $key, int|string $value, int $ttl = null): void
    {
        $this->connect();

        if (is_null($ttl)) {
            $this->redis->set($key, $value);
        } else {
            $this->redis->setex($key, $this->normaliseTtl($ttl), $value);
        }
    }

    /**
     * @throws RedisException
     */
    public function hset(string $key, string $hashKey, int|string $value, int $ttl = null): void
    {
        $this->connect();

        if (is_null($ttl)) {
            $this->redis->hset($key, $hashKey, $value);
        } else {
            $this->redis->setex($key, $this->normaliseTtl($ttl), $value);
        }
    }

    /**
     * @throws RedisException
     */
    public function sadd(string $key, string $value, int $ttl = null): void
    {
        $this->connect();

        if (is_null($ttl)) {
            $this->redis->sAdd($key, $value);
        } else {
            $this->redis->setex($key, $this->normaliseTtl($ttl), $value);
        }
    }

    /**
     * Returns 1 if the timeout was set.
     * Returns 0 if key does not exist or the timeout could not be set.
     * @throws RedisException
     */
    public function expire(string $key, int $ttl = self::MIN_TTL): bool
    {
        $this->connect();

        return $this->redis->expire($key, $this->normaliseTtl($ttl));
    }

    /**
     * Removes the specified keys. A key is ignored if it does not exist.
     * Returns the number of keys that were removed.
     * @throws RedisException
     */
    public function delete(string $key): false|int
    {
        $this->connect();

        return $this->redis->del($key);
    }

    /**
     * Returns -2 if the key does not exist.
     * Returns -1 if the key exists but has no associated expire. Persistent.
     * @throws RedisException
     */
    public function getTtl(string $key): bool|int
    {
        $this->connect();

        return $this->redis->ttl($key);
    }

    /**
     * Returns 1 if the timeout was removed.
     * Returns 0 if key does not exist or does not have an associated timeout.
     * @throws RedisException
     */
    public function persist(string $key): bool
    {
        $this->connect();

        return $this->redis->persist($key);
    }

    /**
     * The ttl is normalised to be 1 second to 1 hour.
     */
    private function normaliseTtl(int $ttl): float|int
    {
        $ttl = ceil(abs($ttl));

        return ($ttl >= self::MIN_TTL && $ttl <= self::MAX_TTL) ? $ttl : self::MAX_TTL;
    }

    /**
     * Connect only if not connected.
     * @throws RedisException
     */
    private function connect(): void
    {
        if (!$this->redis || $this->redis->ping() !== '+PONG') {
            $this->redis = new Redis();
            $this->redis->connect($this->host, $this->port);
        }
    }

    public function deleteAllKeys(): void
    {
        $this->connect();
        $keys = $this->redis->keys('*');
        foreach ($keys as $key) {
            $this->redis->del($key);
        }
    }

    public function smembers(string $key): array
    {
        $this->connect();
        return $this->redis->sMembers($key);
    }

    public function getByKeyPattern(string $keyPattern): array
    {
        $this->connect();

        $keys = $this->redis->keys($keyPattern);
        $values = [];
        foreach ($keys as $key) {
            $values[$key] = $this->redis->get($key);
        }

        return $values;
    }

    public function hGetAll(string $key): array
    {
        $this->connect();
        /** @var array $result */
        $result = $this->redis->hGetAll($key);

        return $result;
    }
}