<?php

declare(strict_types=1);

namespace Gesparo\HW\Infrastructure\Storage;

use Gesparo\HW\Application\ConditionFactory;
use Gesparo\HW\Application\EventFactory;
use Gesparo\HW\Infrastructure\App\AppException;
use Gesparo\HW\Infrastructure\App\EnvManager;
use Gesparo\HW\Infrastructure\Storage\Redis\ApiStorageFacade;
use Gesparo\HW\Infrastructure\Storage\Redis\ConnectionCreator;

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

                return new ApiStorageFacade(
                    (new ConnectionCreator($host))->create(),
                    new EventFactory(),
                    new ConditionFactory()
                );
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

                return new Mongo\ApiStorageFacade(
                    (new Mongo\ConnectionCreator($host, $user, $password, $database))->create(),
                    new EventFactory(),
                    new ConditionFactory()
                );
            default:
                throw AppException::storageIsInvalid($this->envManager->getStorage());
        }
    }
}
