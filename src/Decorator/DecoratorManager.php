<?php

declare(strict_types=1);

namespace src\Decorator;

use DateTime;
use Exception;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;
use src\Integration\DataProvider;

class DecoratorManager extends DataProvider
{
    /**
     * @param string $host
     * @param string $user
     * @param string $password
     * @param CacheItemPoolInterface $cache
     */
    public function __construct(
        private string $host,
        private string $user,
        private string $password,
        private readonly CacheItemPoolInterface $cache,
        private readonly LoggerInterface $logger
    ) {
        parent::__construct($host, $user, $password);
    }

    /**
     * {@inheritdoc}
     */
    public function getResponse(array $input): array
    {
        $cacheKey = $this->getCacheKey($input);

        if (is_string($cacheKey)) {
            $cacheItem = $this->cache->getItem($cacheKey);

            if ($cacheItem !== null && $cacheItem->isHit()) {
                return $cacheItem->get();
            }

            try {
                $result = parent::get($input);
                $this->cache
                    ->setKeyValue($cacheKey, $result)
                    ->expiresAt(
                        (new DateTime())->modify('+1 day')
                    );

                return $result;
            } catch (Exception $e) {
                $this->logger->critical($e->getMessage() . 'Error' . implode(',', $input));
            }
        }

        return [];
    }

    private function getCacheKey(array $input): bool|string
    {
        return json_encode($input);
    }
}
