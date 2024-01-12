<?php

declare(strict_types=1);

namespace Storage;

use Storage\Interface\StorageInterface;
use Storage\RedisStorage;

class Storage
{
    public $client;

    public static function connect(): StorageInterface
    {
        $storageClass = Storage::getList()[$_ENV['STORAGE']];
        $obj = new $storageClass();
        $obj->buildClient();
        return $obj;
    }

    private static function getList(): array
    {
        return [
            'redis' => RedisStorage::class,
            'mongo' => MongoStorage::class
        ];
    }
}
