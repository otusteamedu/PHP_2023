<?php
declare(strict_types=1);

namespace WorkingCode\Hw12;

use Exception;
use Redis;
use RedisException;
use Symfony\Component\Console\Application as ApplicationConsole;
use Symfony\Component\Dotenv\Dotenv;
use WorkingCode\Hw12\Command\AddRecordInStorageCommand;
use WorkingCode\Hw12\Command\ClearStorageCommand;
use WorkingCode\Hw12\Command\SearchInStorageCommand;
use WorkingCode\Hw12\DTO\Builder\EventDTOBuilder;
use WorkingCode\Hw12\Service\RedisService;
use WorkingCode\Hw12\Service\StorageInterface;

class Application
{
    private StorageInterface $storage;

    /**
     * @throws RedisException
     */
    public function __construct()
    {
        (new Dotenv())->load('.env');

        $redis = new Redis();
        $redis->connect($_ENV['REDIS_HOST'], (int)$_ENV['REDIS_PORT']);
        $this->storage = new RedisService($redis);
    }

    /**
     * @throws Exception
     */
    public function run(): void
    {
        $appConsole = new ApplicationConsole('home work №12', '1.0');
        $appConsole->add(new AddRecordInStorageCommand($this->storage, new EventDTOBuilder()));
        $appConsole->add(new ClearStorageCommand($this->storage));
        $appConsole->add(new SearchInStorageCommand($this->storage, new EventDTOBuilder()));

        $appConsole->run();
    }
}
