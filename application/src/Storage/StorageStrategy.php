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
            case 'mongo':
                $host = $this->envManager->getMongoHost();
                $user = $this->envManager->getMongoUser();
                $password = $this->envManager->getMongoPassword();
                $database = $this->envManager->getMongoDatabase();

                if ($host === null) {
                    throw new \InvalidArgumentException('Mongo host not found');
                }

                if ($user === null) {
                    throw new \InvalidArgumentException('Mongo user not found');
                }

                if ($password === null) {
                    throw new \InvalidArgumentException('Mongo password not found');
                }

                if ($database === null) {
                    throw new \InvalidArgumentException('Mongo database not found');
                }

                return new Mongo\ApiStorageFacade((new Mongo\ConnectionCreator($host, $user, $password, $database))->create());
            default:
                throw AppException::storageIsInvalid($this->envManager->getStorage());
        }
    }
}