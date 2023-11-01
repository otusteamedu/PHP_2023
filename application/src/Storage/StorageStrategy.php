<?php

declare(strict_types=1);

namespace Gesparo\HW\Storage;

use Gesparo\HW\AppException;
use Gesparo\HW\EnvManager;
use Gesparo\HW\Storage\Redis\ApiStorageFacade;
use Gesparo\HW\Storage\Redis\ConnectionCreator;

class StorageStrategy
{
    private EnvManager $envManager;

    public function __construct(EnvManager $envManager)
    {
        $this->envManager = $envManager;
    }

    /**
     * @throws AppException
     * @throws \RedisException
     */
    public function getStorage(): BaseStorageFacade
    {
        switch ($this->envManager->getStorage()) {
            case 'redis':
                $host = $this->envManager->getRedisHost();

                if ($host === null) {
                    throw new \InvalidArgumentException('Redis host not found');
                }

                return new ApiStorageFacade((new ConnectionCreator($host))->create());
            default:
                throw AppException::storageIsInvalid($this->envManager->getStorage());
        }
    }
}